<?php

namespace App\View\Components;

use App\Models\Section;
use Illuminate\View\Component;

class GallerySection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public Section $section)
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

        return view('components.gallery-section', []);
    }
}
