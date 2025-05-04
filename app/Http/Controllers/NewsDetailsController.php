<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\LocationSettings;
use App\Models\News;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use ipinfo\ipinfo\IPinfoException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NewsDetailsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws IPinfoException
     */
    public function newsDetails(LocationSettings $locationSetting, $news): Factory|View|Application
    {
        $allLanguages = [];

        $newsDetails = News::whereSlug($news)->first();

        if ($newsDetails == null) {
            abort(404);
        }

        session()->put('slug', $locationSetting->slug);
        app()->setLocale($locationSetting->language->code);
        session()->put('section', 'news' . '/' . $newsDetails->slug);

        $allNews = [];
        $news = News::whereCountryId($locationSetting->country_id)->get()->except($newsDetails->id);

        foreach ($news as $item) {
            $allNews[] = $item->toComponent();
        }

        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }

        if ($locationSetting->language->code == 'ar'){
            $mata_tags = $newsDetails->meta_tags_arabic;
            $script = $newsDetails->scripts_arabic;
        }
        else {
            $mata_tags = $newsDetails->meta_tags;
            $script = $newsDetails->scripts;
        }

        return view('pages.news-details', [
            'newsDetails' => $newsDetails->toComponent(),
            'scripts' => $script ?? ' ',
            'meta_tags' => $mata_tags ?? ' ',
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
            'allNews' => $allNews,
        ]);
    }
}
