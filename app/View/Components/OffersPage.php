<?php

namespace App\View\Components;

use App\Helpers\AppHelper;
use App\Models\Partner;
use Illuminate\View\Component;

class OffersPage extends Component
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
     */
    public function render()
    {
        $locationSettings = AppHelper::getLocationSettings();
        $allPartners = [];
        $partners = Partner::has('offers')->where('country_id', '=', $locationSettings->country_id)->latest()->get();

        foreach ($partners as $item) {
            $allPartners[] = $item->toComponentWithOffer();
        }

        return view('components.offers-page', [
            'partnersOffer' => $allPartners,
        ]);
    }
}
