<?php

namespace App\View\Components;

use App\Enums\ActiveStatus;
use App\Helpers\AppHelper;
use App\Models\Association;
use Illuminate\View\Component;

class CreateOrderPage extends Component
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
        $allAddresses = [];
        $addresses = \Auth::user()->addresses()->where('country_id', '=', $locationSettings->country_id)->get();

        foreach ($addresses as $item) {
            $allAddresses[] = $item->toComponent();
        }
        $associations = Association::where([
            'country_id' => $locationSettings->country_id,
            'status' => ActiveStatus::ACTIVE,
        ])->orderBy('priority')->get();
        $allAssociation = [];
        foreach ($associations as $item) {
            $allAssociation[] = $item->toComponent($locationSettings->language->code);
        }

        return view('components.create-order-page', [
            'addresses' => $allAddresses,
            'associations' => $allAssociation,
        ]);
    }
}
