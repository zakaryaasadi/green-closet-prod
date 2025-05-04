<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Language;
use App\Models\LocationSettings;
use App\Models\Page;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use ipinfo\ipinfo\IPinfoException;

class HomePageController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @throws IPinfoException
     */
    public function indexHomePage(): Factory|View|Application
    {
        $locale = app()->getLocale();
        if (!$locale) {
            app()->setLocale('en');
            $locale = 'en';
            session()->put('locale', $locale);
        }


        $clientCountry = AppHelper::getCurrentCountry();

        $language = Language::where('code', $locale)->first();

        $page = Page::where(['is_home' => true, 'language_id' => $language->id, 'country_id' => $clientCountry->id])->first();

        $page['sections'] = $page->activeSortedSections()->get();

        $locationSettings = LocationSettings::where(['language_id' => $language->id, 'country_id' => 1])->first();

        return view('home', [
            'data' => $page,
            'locationSettings' => $locationSettings['structure'],
        ]);
    }
}
