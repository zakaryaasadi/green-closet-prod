<?php

namespace App\View\Components;

use App\Helpers\AppHelper;
use App\Models\Event;
use Illuminate\View\Component;

class EventsSection extends Component
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
        $allEvents = [];
        $events = Event::where('country_id', '=', $locationSettings->country_id)->latest()->paginate(8);

        foreach ($events as $event) {
            $allEvents[] = $event->toComponent();
        }

        return view('components.events-section', [
            'events' => $allEvents,
            'pagination' => $events,
        ]);

    }
}
