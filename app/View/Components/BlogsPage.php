<?php

namespace App\View\Components;

use App\Helpers\AppHelper;
use App\Models\Blog;
use Illuminate\View\Component;

class BlogsPage extends Component
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
        $allBlogs = [];
        $blogs = Blog::where('country_id', '=', $locationSettings->country_id)->latest()->paginate(5);

        foreach ($blogs as $item) {
            $allBlogs[] = $item->toComponent();
        }

        return view('components.blogs-page', [
            'blogs' => $allBlogs,
            'pagination' => $blogs,
        ]);

    }
}
