<?php

namespace App\Http\Controllers;

use App\Models\Blog;
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
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class BlogDetailsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws IPinfoException
     */
    public function blogDetails(LocationSettings $locationSetting, $blog): Factory|View|Application
    {
        $allLanguages = [];

        $blogDetails = Blog::whereSlug($blog)->first();

        if ($blogDetails == null) {
            abort(404);
        }

        session()->put('slug', $locationSetting->slug);
        app()->setLocale($locationSetting->language->code);
        session()->put('section', 'blogs' . '/' . $blogDetails->slug);

        $allBlogs = [];
        $blogs = Blog::whereCountryId($locationSetting->country_id)->get()->except($blogDetails->id);

        foreach ($blogs as $item) {
            $allBlogs[] = $item->toComponent();
        }

        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }
        if ($locationSetting->language->code == 'ar'){
            $mata_tags = $blogDetails->meta_tags_arabic;
        }
        else {
            $mata_tags = $blogDetails->meta_tags;
        }

        return view('pages.blog-details', [
            'blogDetails' => $blogDetails->toComponent(),
            'meta_tags' => $mata_tags ?? ' ',
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
            'allBlogs' => $allBlogs,
        ]);
    }
}
