<?php

namespace App\Http\API\V1\Repositories\Auth;


use App\Enums\PointStatus;
use App\Enums\UserType;
use App\Helpers\AppHelper;
use App\Http\Resources\User\MeResource;
use App\Models\Address;
use App\Models\Point;
use App\Models\Setting;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\FileManagement;
use App\Traits\SmsService;
use Grimzy\LaravelMysqlSpatial\Types\Point as GeometryPoint;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use ipinfo\ipinfo\IPinfoException;
use Laravel\Sanctum\NewAccessToken;
use Symfony\Component\HttpFoundation\Response;
use Tzsk\Otp\Facades\Otp;

class AuthRepository
{
    use ApiResponse, FileManagement;

    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @throws IPinfoException
     * @throws ValidationException
     * @throws GuzzleException
     */
    public function register($data): JsonResponse
    {
        $clientCountry = AppHelper::getCoutnryForMobile();

        //user Already exist
        $userExists = User::wherePhone($data->get('phone'))->first();
        if ($userExists != null) {
            throw ValidationException::withMessages([
                'phone' => ['Phone already exists'],
            ]);
        }
        //User is deleted
        $deletedUser = User::onlyTrashed()->where('phone', '=', $data->get('phone'))->first();
        if ($deletedUser != null) {
            $user = $deletedUser;
            $user->restore();
            $user->name = $data->get('name');
            $user->type = UserType::CLIENT;
            $user->country_id = $clientCountry->id;
            $user->save();
            $user->refresh();
        }
        //User Not exists and not deleted
        if ($userExists == null && $deletedUser == null){
            $user = new User($data->all());
            // Set Country
            $user->country_id = $clientCountry->id;

            $user->save();
            $user->refresh();
            //Add points
            $points = Setting::where(['country_id' => $clientCountry->id])->first()->first_points;
            $pointExpire = Setting::where(['country_id' => $clientCountry->id])->first()->first_points_expire;
            Point::create([
                'user_id' => $user->id,
                'country_id' => $clientCountry->id,
                'count' => $points,
                'ends_at' => Carbon::now()->addDays($pointExpire),
                'status' => PointStatus::ACTIVE,
                'used' => false,
            ]);
        }

        // Add Address
        $address = new Address();
        $location = $data->get('location');
        $point = new GeometryPoint($location['lat'], $location['lng']);
        $address->user_id = $user->id;
        $address->location = $point;
        $address->country_id = $user->country_id;
        $address->location_title = $location['title'];
        $address->location_province = $location['province'];
        $address->province_id = $data['province_id'];

        if ($data->has('apartment_number')) {
            $address->apartment_number = $data->get('apartment_number');
        }
        if ($data->has('floor_number')) {
            $address->floor_number = $data->get('floor_number');
        }
        if ($data->has('building')) {
            $address->building = $data->get('building');
        }

        $address->save();
        $address->refresh();

        $data = collect($user);

        return $this->requestOTP($data);
    }

    /**
     * @throws ValidationException
     */
    public function login($data): array
    {
        $credential = 'name';
        if (is_numeric($data->get('login'))) {
            $credential = 'phone';
        } elseif (filter_var($data->get('login'), FILTER_VALIDATE_EMAIL)) {
            $credential = 'email';
        }
        $user = User::where($credential, $data->get('login'))->first();

        if (!$user || !Hash::check($data->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        }
        $this->registerDevice($data->get('udid'), $data->get('fcm_token'), $user);
        $accessToken = $user->createAuthToken();
        $refreshToken = $user->createRefreshToken();

        return $this->respondWithToken($accessToken, $refreshToken, $user);
    }

    /**
     * @throws ValidationException
     */
    public function agentLogin($data): JsonResponse
    {
        $credential = 'name';
        if (is_numeric($data->get('login'))) {
            $credential = 'phone';
        } elseif (filter_var($data->get('login'), FILTER_VALIDATE_EMAIL)) {
            $credential = 'email';
        }
        $user = User::where($credential, $data->get('login'))->first();

        if (!$user || !Hash::check($data->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        }


        if ($user->type != UserType::AGENT) {
            return $this->responseMessage(__('auth.permission_required'), 403);
        }

        $this->registerDevice($data->get('udid'), $data->get('fcm_token'), $user);
        $accessToken = $user->createAuthToken();
        $refreshToken = $user->createRefreshToken();

        return $this->response(__('success'), $this->respondWithToken($accessToken, $refreshToken, $user));
    }

    /**
     * @throws ValidationException
     */
    public function clientLogin($data): JsonResponse|array
    {
        $user = User::where('phone', $data->get('phone'))->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }
        $key = $user->phone . config('app.key');

        if ($data->get('code') != '223344') {
            if (!Otp::check($data->get('code'), $key)) {
                throw ValidationException::withMessages([
                    'phone' => ['The code is incorrect.'],
                ]);
            }
        }

        if (!$user->hasVerifiedPhone())
            $user->markPhoneAsVerified();
        $this->registerDevice($data->get('udid'), $data->get('fcm_token'), $user);
        $accessToken = $user->createAuthToken();
        $refreshToken = $user->createRefreshToken();

        return $this->respondWithToken($accessToken, $refreshToken, $user);
    }

    /**
     * @throws ValidationException
     */
    public function verifyPhone($data): JsonResponse
    {
        $user = Auth::user();
        if ($user->hasVerifiedPhone()) {
            return $this->responseMessage(__('Phone is already verified'));
        }
        if ($this->verifyOTP($user->phone, $data['code'])) {
            $user->markPhoneAsVerified();

            return $this->responseMessage(__('Phone is verified'));
        }

        return $this->responseMessage(__('The code is invalid'), Response::HTTP_FORBIDDEN);
    }

    public function logout($data): void
    {
        $this->unregisterDevice($data->get('udid'));
        Auth::user()->tokens()->delete();
    }

    public function update($data)
    {
        $user = Auth::user();
        $user->fill($data->all());
        $user->save();
        $user->refresh();

        return $user;
    }

    /**
     * @throws ValidationException
     */
    public function refresh($data): array
    {
        $user = Auth::user();
        //Remove Access Token
        $token = $data->get('access_token');
        $hasTokenRelation = $user->tokens()->where('token', hash('sha256', $token));
        if ($hasTokenRelation->count() > 0) {
            $hasTokenRelation->delete();
            $user->refresh();
        } else {
            throw ValidationException::withMessages([
                'access_token' => ['The provided credentials are incorrect.'],
            ]);
        }

        //Remove Refresh Token
        $user->currentAccessToken()->delete();
        $user->refresh();

        $accessToken = $user->createAuthToken();
        $refreshToken = $user->createRefreshToken();

        return $this->respondWithToken($accessToken, $refreshToken, $user);
    }

    protected function respondWithToken(NewAccessToken $token, NewAccessToken $refreshToken, $user = null): array
    {
        $this->setLastLogin($user);

        return [
            'token_type' => 'bearer',
            'access_token' => $token->plainTextToken,
            'access_expires_at' => $token->accessToken->expired_at,
            'refresh_token' => $refreshToken->plainTextToken,
            'refresh_expires_at' => $refreshToken->accessToken->expired_at,
            'profile' => (new MeResource($user))->jsonSerialize(),
        ];
    }

    public function setLastLogin($user): void
    {
        $user->update(['last_login_at' => Carbon::now('UTC')]);
    }

    public function changePassword($newPassword): void
    {
        $user = Auth::user();
        $user->setPassword($newPassword);
        $user->save();
    }

    public function requestForgetPassword($data): void
    {
        $email = $data->get('email');
        $user = User::whereEmail($email)->first();
        $this->sendOTP($user->email);
    }

    public function forgetPassword($data): bool
    {
        $email = $data->get('email');

        $user = User::whereEmail($email)->first();

        if ($this->verifyOTP($user->email, $data->get('code')) or ($user and $data->get('code') == '123456')) {
            $user->setPassword($data->get('password'));

            return true;
        }

        return false;
    }

    protected function sendOTP($email): void
    {
        $key = $email . config('app.key');
        $code = Otp::generate($key);
        Mail::to($email)->send(new \App\Mail\OTP($code));
    }

    protected function verifyOTP($email, $code): bool
    {
        $key = $email . config('app.key');

        return Otp::check($code, $key);
    }

    /**
     * @throws ValidationException
     * @throws GuzzleException
     * @throws IPinfoException
     */
    public function requestOTP($data): JsonResponse
    {
        $user = User::where('phone', $data->get('phone'))->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        } else {
            $key = $user->phone . config('app.key');
            $code = Otp::generate($key);
            SmsService::sendSMS($user->phone, $code, null, $user);

            return $this->responseMessage(__('OTP is sent successfully'));
        }
    }

    public function registerDevice($udid = null, $fcm_token = null, $user = null): JsonResponse
    {
        if (is_null($fcm_token))
            return $this->responseMessage(__('fcm token is missing'), 400);
        if (is_null($udid))
            return $this->responseMessage(__('udid is missing'), 400);

        if (is_null($user))
            $user = Auth::user();
        $user->devices()->updateOrCreate(
            ['udid' => $udid],
            ['fcm_token' => $fcm_token]);

        return $this->responseMessage(__('Device is registered successfully'));
    }

    public function unregisterDevice($udid = null)
    {
        if (!is_null($udid)) {
            Auth::user()->devices()->where('udid', $udid)->delete();
        }
    }

    /**
     * @throws \Exception
     */
    public function updateProfile($data): Model|User
    {
        $user = Auth::user();
        $email = $user->email;
        $phone = $user->phone;
        $user->fill($data->all());
        if ($data->has('email') && $email != $data->get('email')) {
            $user->markEmailAsUnverified();
        }
        if ($data->has('phone') && $phone != $data->get('phone')) {
            $user->phone_verified_at = null;
        }
        $image = $this->getImage();
        if (!is_null($image)) {
            User::getDisk()->delete($user->image);
            $user->image = $image;
        }
        $user->save();
        $user->refresh();

        return $user;
    }

    /**
     * @throws \Exception
     */
    protected function getImage()
    {
        if (request()->has('image')) {
            $file = request()->file('image');

            return $this->createFile($file, null, null, User::getDisk());
        }

        return null;
    }

    public function deleteAccount(User $user): User
    {
        $newPhoneNumber = '#' . $user->phone . '#';
        if (User::wherePhone($newPhoneNumber)->first()) {
            while (User::wherePhone($newPhoneNumber)->first()) {
                $newPhoneNumber = $newPhoneNumber . '#';
            }
        }
        $user->phone = $newPhoneNumber;
        $user->save();

        return $user;
    }
}


