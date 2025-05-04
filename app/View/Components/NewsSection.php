<?php

namespace App\View\Components;

use App\Helpers\AppHelper;
use App\Models\News;
use Illuminate\View\Component;

class NewsSection extends Component
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
        $allNews = [];
        $count = $this->section['count'];
        $news = News::where('country_id', '=', $locationSettings->country_id)->latest()->orderBy('display_order')->take($count ?? 3)->get();
        foreach ($news as $item) {
            $allNews[] = $item->toComponent();
        }

        return view('components.news-section', [
            'news' => $allNews,
        ]);

    }
}
