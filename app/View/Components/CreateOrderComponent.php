<?php

namespace App\View\Components;

use App\Enums\ActiveStatus;
use App\Helpers\AppHelper;
use App\Models\Association;
use App\Models\Country;
use App\Models\Item;
use App\Models\Province;
use App\Models\Setting;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\View\Component;

class CreateOrderComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public array $section)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     *
     * @throws GuzzleException
     */
    public function render()
    {
        $country_id = AppHelper::getLocationSettings()->country_id;
        $country = Country::whereId($country_id)->first();
        AppHelper::setCountryInfo($country);
        $locationSettings = AppHelper::getLocationSettings();
        $associations = Association::where([
            'country_id' => $locationSettings->country_id,
            'status' => ActiveStatus::ACTIVE,
        ])->orderBy('priority')->get();
        $allAssociation = [];
        foreach ($associations as $association) {
            $allAssociation[] = $association->toComponent($locationSettings->language->code);
        }


        $items = Item::where('country_id', '=', $locationSettings->country_id)->get();
        $allItems = [];
        foreach ($items as $item) {
            $allItems[] = $item->toComponent($locationSettings->language->code);
        }

        $settings = Setting::where(['country_id' => $country_id])?->first() ??
            Setting::where(['country_id' => null])?->first();

        $flags = [];
        $code_numbers = [];
        $currentCountry = Country::whereId($locationSettings->country_id)->first();
        $currentCountryNumber = $currentCountry->code_number;
        $flags[] = $currentCountry->flag;
        $code_numbers[] = $currentCountry->code_number;

        $countries = Country::where(['status' => ActiveStatus::ACTIVE])->get();

        foreach ($countries as $country) {
            if ($currentCountryNumber != $country->code_number) {
                $flags[] = $country->flag;
                $code_numbers[] = $country->code_number;
            }
        }

        return view('components.create-order-component', [
            'items' => $allItems,
            'otp_active' => $settings->otp_active,
            'associations' => $allAssociation,
            'flags' => $flags,
            'codes' => $code_numbers,
            'currentCode' => $currentCountry->code_number,
            'currentFlag' => $currentCountry->flag,
            'provinces' => Province::whereCountryId($locationSettings->country_id)->get(),
        ]);
    }
}

