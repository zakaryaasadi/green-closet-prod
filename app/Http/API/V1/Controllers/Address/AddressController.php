<?php

namespace App\Http\API\V1\Controllers\Address;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Address\AddressRepository;
use App\Http\API\V1\Requests\Address\StoreAddressRequest;
use App\Http\API\V1\Requests\Address\StoreUserAddressRequest;
use App\Http\API\V1\Requests\Address\UpdateAddressRequest;
use App\Http\API\V1\Requests\Address\UpdateUserAddressRequest;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\SimpleAddressResource;
use App\Models\Address;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @group Address
 * APIs for address settings
 */
class AddressController extends Controller
{
    protected AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this
            ->middleware('auth:sanctum');
        $this->addressRepository = $addressRepository;
        $this->authorizeResource(Address::class);
    }

    /**
     * Show all address
     *
     * This endpoint lets you show all address
     *
     * @responseFile storage/responses/address/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[user_id] string Field to filter items by user_id.
     * @queryParam filter[location_id] string Field to filter items by location_id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam filter[position] string Field to filter items by area.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[default] string Field to filter items by default.
     * @queryParam sort string Field to sort items by user_id, location_id, name, type, default.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->addressRepository->index();

        return $this->showAll($paginatedData->getData(), AddressResource::class, $paginatedData->getPagination());
    }

    /**
     * Show customer addresses
     *
     * This endpoint lets you show all customer addresses
     *
     * @responseFile storage/responses/address/customer/index-user-addresses.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[location_id] string Field to filter items by location_id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam filter[position] string Field to filter items by area.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[default] string Field to filter items by default.
     * @queryParam sort string Field to sort items by location_id, name, type, default.
     *
     * @return JsonResponse
     */
    public function indexUserAddress(): JsonResponse
    {
        $paginatedData = $this->addressRepository->indexUserAddress();

        return $this->showAll($paginatedData->getData(), SimpleAddressResource::class, $paginatedData->getPagination());
    }

    /**
     * Add customer address
     *
     * This endpoint lets you store customer address
     *
     * @responseFile storage/responses/address/customer/store-user-address.json
     *
     * @param StoreUserAddressRequest $request
     * @return JsonResponse
     */
    public function storeUserAddress(StoreUserAddressRequest $request): JsonResponse
    {
        $address = $this->addressRepository->storeAddress(collect($request->validated()), Auth::user()->id);

        return $this->showOne($address, SimpleAddressResource::class, __('Address added successfully'));
    }

    /**
     * Show specific address
     *
     * This endpoint lets you show specific address
     *
     * @responseFile storage/responses/address/show.json
     *
     * @param Address $address
     * @return JsonResponse
     */
    public function show(Address $address): JsonResponse
    {
        return $this->showOne($this->addressRepository->show($address), AddressResource::class);
    }

    /**
     * Show specific address for customer
     *
     * This endpoint lets you show specific address for customer
     *
     * @responseFile storage/responses/address/customer/show.json
     *
     * @param Address $address
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function showUserAddress(Address $address): JsonResponse
    {
        $this->authorize('showUserAddress', $address);

        return $this->showOne($this->addressRepository->show($address), SimpleAddressResource::class);
    }

    /**
     * Add address
     *
     * This endpoint lets you add address
     *
     * @responseFile storage/responses/address/store.json
     *
     * @param StoreAddressRequest $request
     * @return JsonResponse
     */
    public function store(StoreAddressRequest $request): JsonResponse
    {
        $address = $this->addressRepository->storeAddress(collect($request->validated()), $request->get('user_id'));

        return $this->showOne($address, AddressResource::class, __('Address added successfully'));
    }

    /**
     * Update specific address
     *
     * This endpoint lets you update specific address
     *
     * @responseFile storage/responses/address/update.json
     *
     * @param UpdateAddressRequest $request
     * @param Address $address
     * @return JsonResponse
     */
    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        $data = collect($request->validated());
        $addressUpdate = $this->addressRepository->updateAddress($address, $data);

        return $this->showOne($addressUpdate, AddressResource::class, __("Address's information updated successfully"));
    }

    /**
     * Update customer specific address
     *
     * This endpoint lets you update customer specific address
     *
     * @responseFile storage/responses/address/customer/update-user-address.json
     *
     * @param UpdateUserAddressRequest $request
     * @param Address $address
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function updateUserAddress(UpdateUserAddressRequest $request, Address $address): JsonResponse
    {
        $this->authorize('updateUserAddress', $address);
        $data = collect($request->validated());
        $addressUpdate = $this->addressRepository->updateAddress($address, $data);

        return $this->showOne($addressUpdate, SimpleAddressResource::class, __("Address's information updated successfully"));
    }

    /**
     * Delete specific address
     *
     * This endpoint lets you delete specific address
     *
     * @responseFile storage/responses/address/delete.json
     *
     * @param Address $address
     * @return JsonResponse
     */
    public function destroy(Address $address): JsonResponse
    {
        $this->addressRepository->delete($address);

        return $this->responseMessage(__('Address deleted successfully'));
    }

    /**
     * Delete user specific address
     *
     * This endpoint lets you delete user specific address
     *
     * @responseFile storage/responses/address/customer/delete-user-address.json
     *
     * @param Address $address
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function deleteUserAddress(Address $address): JsonResponse
    {
        $this->authorize('deleteUserAddress', $address);
        $this->addressRepository->delete($address);

        return $this->responseMessage(__('Address deleted successfully'));
    }
}
