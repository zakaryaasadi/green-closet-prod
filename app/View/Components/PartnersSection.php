<?php

namespace App\View\Components;

use App\Helpers\AppHelper;
use App\Models\Partner;
use Illuminate\View\Component;

class PartnersSection extends Component
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
        $partners = Partner::where('country_id', '=', $locationSettings->country_id)->latest()->take(8)->get();
        foreach ($partners as $item) {
            $allPartners[] = $item->toComponent();
        }

        return view('components.partners-section', [
            'partners' => $allPartners,
        ]);
    }
}
