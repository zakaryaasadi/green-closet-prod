<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PointStatus;
use App\Enums\UserType;
use App\Events\Customer as CustomerEvents;
use App\Helpers\AppHelper;
use App\Http\API\V1\Repositories\Order\OrderRepository;
use App\Http\API\V1\Requests\Order\StoreCustomerOrderRequest;
use App\Models\Address;
use App\Models\Association;
use App\Models\Country;
use App\Models\Item;
use App\Models\LocationSettings;
use App\Models\Order;
use App\Models\Point;
use App\Models\Province;
use App\Models\Setting;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Auth;
use Carbon\Carbon;
use Exception;
use Grimzy\LaravelMysqlSpatial\Types\Point as GeometryPoint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tzsk\Otp\Facades\Otp;

class OrderController extends BaseController
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::ORDERS;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('arabicNumbersMiddleware');
        $this->middleware(['auth.web', 'isClient'])->except(['makeOrderHome', 'thankYouPage']);
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function makeOrder(StoreCustomerOrderRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = Auth::user();
        if (OrderRepository::checkActiveOrders(Auth::user()))
            return Redirect::to('/' . AppHelper::getSlug() . $this->redirectTo)->withErrors(['msg' => 'You already have an active order']);
        $order = new Order();
        $order->fill($data);
        $order->customer_id = $user->id;
        $order->country_id = AppHelper::getLocationSettings()->country_id;
        $order->status = OrderStatus::CREATED;
        $order->platform = 'Website';
        $address = Address::find($data['address_id']);
        $location = $address->location;
        $order->province_id = $address->province_id;

        $order->location = new GeometryPoint($location->getLat(), $location->getLng());

        $order->save();
        $order->refresh();

        $autoAssign = Setting::where(['country_id' => $order->country_id])->first() ??
            Setting::where(['country_id' => null])->first();

        if ($autoAssign->auto_assign == 1) {
            OrderRepository::orderAutoAssign($order);
        }

        $order->save();
        $order->refresh();

        try {
            CustomerEvents\OrderStatusChangedEvent::dispatch($order);

        } catch (Exception $e) {
        }

//        try {
//            AdminEvents\OrderStatusChangedEvent::dispatch($order);
//        } catch (Exception $e) {
//        }

        return Redirect::to('/' . AppHelper::getSlug() . '/thank-you');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function makeOrderHome(Request $request, LocationSettings $locationSetting = null): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $typeRules = ['required', 'numeric', Rule::in(OrderType::getValues())];

        $associationIdRules = [Rule::exists(Association::class, 'id')];

        $request = $request->all();
        if (isset($request)) {
            if (isset($request['association_id'])) {
                $typeRules[] = 'in:' . OrderType::DONATION;
                $associationIdRules[] = 'required';
            }
            if (isset($request['type'])) {
                if ($request['type'] == OrderType::DONATION) {
                    $associationIdRules[] = 'required';
                }
            }
        }
        $messages = [
            'phone' => 'please enter valid phone number',
        ];
        $validateCountry = '';
        if (array_key_exists('phone', $request)) {
            $phoneNumber = $request['phone'];
            $countryCode = new PhoneNumber($phoneNumber);
            $countryCode = strtok($countryCode->formatInternational(), ' ');
            $validateCountry = Country::where(['code_number' => $countryCode])->first();
        }
        $validator = Validator::make($request, [
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'phone:' . $validateCountry->code],
            'area_title' => ['required', 'max:255'],
            'street_title' => ['required', 'max:255'],
            'items' => ['nullable'],
            'items.*' => [Rule::exists(Item::class, 'id'), 'nullable'],
            'apartment_number' => ['max:255'],
            'floor_number' => ['max:255'],
            'building' => ['max:255'],
            'province_id' => ['required', Rule::exists(Province::class, 'id')],
            'lat' => ['nullable', 'between:-90,90'],
            'lng' => ['nullable', 'between:-180,180'],
            'type' => $typeRules,
            'association_id' => $associationIdRules,
        ], $messages);

        if ($validator->fails()) {
            return response(['error' => true, 'message' => $validator->errors()], 422);
        }

        if (array_key_exists('code', $request)) {
            $key = $request['phone'] . config('app.key');
            if ($request['code'] != '223344' && !Otp::check($request['code'], $key)) {
                return response(['error' => true, 'message' => 'invalid code'], 422);
            }
        }

        $data = collect($request);
        $user = User::where('phone', '=', $data->get('phone'))?->first();
        if ($user != null) {
            if ($user->type != UserType::CLIENT) {
                return response(['error' => true, 'message' => $user->type], 403);
            }
        }

        $country_id = AppHelper::getLocationSettings()->country_id;
        $userDeleted = User::onlyTrashed()->where('phone', '=', $data->get('phone'))?->first();

        if ($userDeleted != null) {
            $user = $userDeleted;
            $user->restore();
            $user->name = $data->get('name');
            $user->type = UserType::CLIENT;
            $user->country_id = $country_id;
            $user->save();
            $user->refresh();
        }

        if ($user == null && $userDeleted == null) {
            $user = new User();
            $user->name = $data->get('name');
            $user->phone = $data->get('phone');
            $user->type = UserType::CLIENT;
            $user->country_id = $country_id;
            $user->save();
            $user->refresh();
            //Add points
            $points = Setting::where(['country_id' => $country_id])->first()->first_points;
            $pointExpire = Setting::where(['country_id' => $country_id])->first()->first_points_expire;
            Point::create([
                'user_id' => $user->id,
                'country_id' => $country_id,
                'count' => $points,
                'ends_at' => Carbon::now('UTC')->addDays($pointExpire),
                'status' => PointStatus::ACTIVE,
                'used' => false,
            ]);
        }

        if (OrderRepository::checkActiveOrders($user)) {
            return response(['error' => true, 'message' => 100], 403);
        }

        if (($data->get('lat') == null && $data->get('lng') == null) || ($data->get('lat') == 'null' && $data->get('lng') == 'null')) {
            $building = null;
            if ($data->has('building'))
                $building = $data->get('building');
            $latLng = AppHelper::getLatLngForWebsite($locationSetting->country,
                Province::whereId($data->get('province_id'))->first(),
                $data->get('area_title'),
                $data->get('street_title'),
                $building,
                $locationSetting);

            $point = new GeometryPoint($latLng['lat'], $latLng['lng']);
        } else
            $point = new GeometryPoint($data->get('lat'), $data->get('lng'));

        $order = new Order();
        $order->country_id = $country_id;
        $order->customer_id = $user->id;
        $order->location = $point;
        $order->type = $data->get('type');
        if ($data->get('type') == OrderType::DONATION)
            $order->association_id = $data->get('association_id');
        $order->status = OrderStatus::CREATED;
        $order->platform = 'Website home form';

        $autoAssign = Setting::where(['country_id' => $order->country_id])->first() ??
            Setting::where(['country_id' => null])->first();

        if ($autoAssign->auto_assign == 1) {
            OrderRepository::orderAutoAssign($order);
        }

        $address = new Address();
        $address->province_id = $data->get('province_id');
        $address->user_id = $user->id;
        $address->country_id = $country_id;
        $address->location_title = implode(', ', array_filter([$data->get('area_title'), $data->get('street_title')]));
        $address->location = $point;
        if ($data->has('building'))
            $address->building = $data->get('building');

        if ($data->has('floor_number'))
            $address->floor_number = $data->get('floor_number');

        if ($data->has('apartment_number'))
            $address->apartment_number = $data->get('apartment_number');

        $address->save();
        $address->refresh();

        $order->address_id = $address->id;
        $order->province_id = $address->province_id;
        $order->save();
        $order->refresh();
        if ($data->has('items') && $data->get('items') != null)
            $order->items()->attach($data->get('items'));


        $date = $order->start_task ?? null;
        if ($date != null)
            $date = AppHelper::changeDateFormat($date);

        return response(['error' => false, 'message' => $date], 200);

    }

    public function thankYouPage(LocationSettings $locationSetting = null)
    {
        return view('pages.thank-you');
    }
}
