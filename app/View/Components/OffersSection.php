<?php

namespace App\View\Components;

use App\Helpers\AppHelper;
use App\Models\Offer;
use App\Models\Section;
use Illuminate\View\Component;

class OffersSection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public Section $section)
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
        $allOffers = [];
        $offers = Offer::where('country_id', '=', $locationSettings->country_id)->latest()->take(5)->get();
        foreach ($offers as $item) {
            $allOffers[] = $item->toComponent();
        }

        return view('components.offers-section', [
            'offers' => $allOffers,
        ]);

    }
}
