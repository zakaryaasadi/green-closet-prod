<?php

namespace App\View\Components;

use App\Helpers\AppHelper;
use App\Models\News;
use Illuminate\View\Component;

class NewsPage extends Component
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
        $news = News::where('country_id', '=', $locationSettings->country_id)->latest()->paginate(5);

        foreach ($news as $item) {
            $allNews[] = $item->toComponent();
        }

        return view('components.news-page', [
            'news' => $allNews,
            'pagination' => $news,
        ]);

    }
}
