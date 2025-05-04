<?php

namespace App\Http\API\V1\Controllers\Country;

use App\Helpers\AppHelper;
use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Country\CountryRepository;
use App\Http\API\V1\Requests\Country\StoreCountryRequest;
use App\Http\API\V1\Requests\Country\UpdateCountryRequest;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Country\SimpleCountryWithItemResource;
use App\Models\Country;
use App\Models\Setting;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

/**
 * @group Countries
 * APIs for country settings
 */
class CountryController extends Controller
{
    protected CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->middleware(['auth:sanctum'])->except(['getCountriesForClient', 'showCountryForClient']);
        $this->countryRepository = $countryRepository;
        $this->authorizeResource(Country::class);
    }

    /**
     * Show all countries
     *
     * This endpoint lets you show all countries
     *
     * @responseFile storage/responses/countries/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam filter[code] string Field to filter items by code.
     * @queryParam sort string Field to sort items by id,name_ar,name_en,code.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->countryRepository->index();

        return $this->showAll($paginatedData->getData(), CountryResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all countries for customer
     *
     * This endpoint lets you show all countries for customer
     *
     * @responseFile storage/responses/countries/customer-index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam filter[code] string Field to filter items by code.
     * @queryParam sort string Field to sort items by id,name_ar,name_en,code.
     *
     * @return JsonResponse
     */
    public function getCountriesForClient(): JsonResponse
    {
        $paginatedData = $this->countryRepository->indexCountriesForClient();

        return $this->showAll($paginatedData->getData(), SimpleCountryWithItemResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific country
     *
     * This endpoint lets you show specific country
     *
     * @responseFile storage/responses/countries/show.json
     *
     * @param Country $country
     * @return JsonResponse
     */
    public function show(Country $country): JsonResponse
    {
        return $this->showOne($this->countryRepository->show($country), CountryResource::class);
    }

    /**
     * Show specific country for client
     *
     * This endpoint lets you show specific country for client
     *
     * @responseFile storage/responses/countries/client-show.json
     *
     * @param Country $country
     * @return JsonResponse
     */
    public function showCountryForClient(Country $country): JsonResponse
    {
        return $this->showOne($this->countryRepository->show($country), SimpleCountryWithItemResource::class);
    }

    /**
     * Add country
     *
     * This endpoint lets you add country
     *
     * @responseFile storage/responses/countries/store.json
     *
     * @param StoreCountryRequest $request
     * @return JsonResponse
     *
     * @throws GuzzleException
     */
    public function store(StoreCountryRequest $request): JsonResponse
    {
        $country = $this->countryRepository->store($request->validated());

        $this->countryRepository->createMainPages($country);
        $this->countryRepository->createTargetTable($country);
        AppHelper::setCountryInfo($country);

        return $this->showOne($country, CountryResource::class, __('The country added successfully'));
    }

    /**
     * Update specific country
     *
     * This endpoint lets you update specific country
     *
     * @responseFile storage/responses/countries/update.json
     *
     * @param UpdateCountryRequest $request
     * @param Country $country
     * @return JsonResponse
     */
    public function update(UpdateCountryRequest $request, Country $country): JsonResponse
    {
        $countryUpdated = $this->countryRepository->updateWithMeta($country, $request->validated());

        return $this->showOne($countryUpdated, CountryResource::class, __("Country's information updated successfully"));

    }

    /**
     * Delete specific country
     *
     * This endpoint lets you delete specific country
     *
     * @responseFile storage/responses/countries/delete.json
     *
     * @param Country $country
     * @return JsonResponse
     */
    public function destroy(Country $country): JsonResponse
    {
        if (Setting::where(['country_id' => null])->first()->default_country_id == $country->id)
            return $this->response(__('This country is the default one'), [], null, 422);

        $this->countryRepository->deleteCountry($country);

        return $this->responseMessage(__('Country deleted successfully'));
    }
}
