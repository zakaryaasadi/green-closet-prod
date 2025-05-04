<?php

namespace App\Http\API\V1\Controllers\Auth;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Auth\AuthRepository;
use App\Http\API\V1\Requests\Auth\ChangePasswordRequest;
use App\Http\API\V1\Requests\Auth\ClientLoginRequest;
use App\Http\API\V1\Requests\Auth\ClientRegisterRequest;
use App\Http\API\V1\Requests\Auth\ForgetPasswordRequest;
use App\Http\API\V1\Requests\Auth\LoginRequest;
use App\Http\API\V1\Requests\Auth\LogoutRequest;
use App\Http\API\V1\Requests\Auth\RefreshRequest;
use App\Http\API\V1\Requests\Auth\RequestForgetPasswordRequest;
use App\Http\API\V1\Requests\Auth\RequestOTP;
use App\Http\API\V1\Requests\Auth\SendOtpRequest;
use App\Http\API\V1\Requests\Auth\UpdateRequest;
use App\Http\API\V1\Requests\Auth\VerifyPhoneRequest;
use App\Http\Resources\User\FullUserResource;
use App\Http\Resources\User\MeResource;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Auth
 * APIs for authentication settings
 */
class AuthController extends Controller
{
    protected AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->middleware('arabicNumbersMiddleware');
        $this->middleware('auth:sanctum')
            ->except([
                'login',
                'agentLogin',
                'requestForgetPassword',
                'requestOTP',
                'forgetPassword',
                'clientLogin',
                'register',
            ]);

        $this->middleware('abilities:refresh')
            ->only(['refresh', 'logout']);
        $this->authRepository = $authRepository;
    }

    /**
     * Login
     *
     * This endpoint lets you log in with specific user
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/login.json
     *
     * @param LoginRequest $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $authData = $this->authRepository->login($data);

        return $this->response(__('success'), $authData);
    }

    /**
     * Agent Login
     *
     * This endpoint lets you log in with specific agent
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/agent-login.json
     *
     * @param LoginRequest $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function agentLogin(LoginRequest $request): JsonResponse
    {
        $data = collect($request->validated());

        return $this->authRepository->agentLogin($data);


    }

    /**
     * Client Login
     *
     * This endpoint lets you log in with specific client
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/client-login.json
     *
     * @param ClientLoginRequest $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function clientLogin(ClientLoginRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $authData = $this->authRepository->clientLogin($data);

        return $this->response(__('success'), $authData);

    }

    /**
     * Verify Phone
     *
     * This endpoint for Verify Phone
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/verify_phone.json
     *
     * @param VerifyPhoneRequest $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function verifyPhone(VerifyPhoneRequest $request): JsonResponse
    {
        return $this->authRepository->verifyPhone($request->validated());
    }

    /**
     * Register
     *
     * This endpoint lets you add a new client
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/register.json
     *
     * @param ClientRegisterRequest $request
     * @return JsonResponse
     */
    public function register(ClientRegisterRequest $request): JsonResponse
    {
        $data = collect($request->validated());

        return $this->authRepository->register($data);
    }

    /**
     * Logout
     *
     * This endpoint lets you log out
     *
     * @queryParam token string required User's token.
     * @queryParam udid string User's device udid.
     *
     * @responseFile storage/responses/auth/logout.json
     *
     * @param LogoutRequest $request
     * @return JsonResponse
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $this->authRepository->logout($data);

        return $this->responseMessage(__('Successfully logged out'));
    }

    /**
     * Update profile
     *
     * This endpoint lets you update current user's profile
     *
     * @responseFile storage/responses/auth/update.json
     *
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $user = $this->authRepository->update($data);

        return $this->showOne($user, FullUserResource::class, __('Your information updated successfully'));

    }

    /**
     * Request forget password
     *
     * This endpoint lets you update request forget password OTP
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/request_forget_password.json
     *
     * @param RequestForgetPasswordRequest $request
     * @return JsonResponse
     */
    public function requestForgetPassword(RequestForgetPasswordRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $this->authRepository->requestForgetPassword($data);

        return $this->responseMessage(__('Code is sent successfully'));
    }

    /**
     * Request Send OTP
     *
     * This endpoint lets you update request Send OTP
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/send-otp.json
     *
     * @param SendOtpRequest $request
     * @return JsonResponse
     */
    public function sendOtp(SendOtpRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $this->authRepository->requestForgetPassword($data);

        return $this->responseMessage(__('OTP is sent successfully'));
    }

    /**
     * Request send OTP
     *
     * This endpoint lets you request send OTP
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/request-otp.json
     *
     * @param RequestOTP $request
     * @return JsonResponse
     *
     * @throws ValidationException
     * @throws GuzzleException
     */
    public function requestOTP(RequestOTP $request): JsonResponse
    {
        $data = collect($request->validated());

        return $this->authRepository->requestOTP($data);
    }

    /**
     * Forget password
     *
     * This endpoint lets you update user password with OTP verification
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/forget_password.json
     *
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     */
    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        if ($this->authRepository->forgetPassword($data))
            return $this->responseMessage(__('Password is updated successfully'));
        else
            return $this->responseMessage(__('The code is invalid'), Response::HTTP_FORBIDDEN);
    }

    /**
     * Change Password
     *
     * This endpoint lets you change the account password
     *
     * @responseFile storage/responses/auth/change_password.json
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $newPassword = $request->get('new_password');
        $this->authRepository->changePassword($newPassword);

        return $this->responseMessage(__('Password is updated successfully'));

    }

    /**
     * Refresh token
     *
     * This endpoint lets you refresh token to user
     *
     * @queryParam token string required User's token.
     *
     * @responseFile storage/responses/auth/refresh.json
     *
     * @param RefreshRequest $request
     * @return JsonResponse
     *
     * @throws ValidationException
     *
     * @unauthenticated
     */
    public function refresh(RefreshRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $authData = $this->authRepository->refresh($data);

        return $this->response(__('success'), $authData);

    }

    /**
     * Update user profile
     *
     * This endpoint lets you update user profile
     *
     * @responseFile storage/responses/auth/profile.json
     *
     * @param UpdateRequest $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function updateProfile(UpdateRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $user = $this->authRepository->updateProfile($data);

        return $this->showOne($user, MeResource::class);

    }

    /**
     * Delete user account
     *
     * This endpoint lets you delete user account
     *
     * @responseFile storage/responses/auth/delete.json
     *
     * @return JsonResponse
     */
    public function deleteAccount(): JsonResponse
    {
        $this->authRepository->deleteAccount(\Auth::user());

        return $this->responseMessage(__('Account deleted successfully'));
    }
}
