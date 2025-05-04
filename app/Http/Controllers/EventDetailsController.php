<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Language;
use App\Models\LocationSettings;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use ipinfo\ipinfo\IPinfoException;

class EventDetailsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @throws IPinfoException
     */
    public function eventDetails(LocationSettings $locationSetting, $event): Factory|View|Application
    {
        $allLanguages = [];

        $eventDetails = Event::whereSlug($event)->first();
        if ($eventDetails == null) {
            abort(404);
        }

        session()->put('slug', $locationSetting->slug);
        app()->setLocale($locationSetting->language->code);
        session()->put('section', 'events' . '/' . $eventDetails->slug);

        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }

        return view('pages.event-details', [
            'eventDetails' => $eventDetails->toComponent(),
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,

        ]);
    }
}
