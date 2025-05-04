<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'default_page_title' => $this->faker->title(),
            'slug' => $this->faker->slug(),
            'meta_tags' => $this->faker->text(200),
            'country_id' => Country::factory()->create()->id,
            'language_id' => Language::factory()->create()->id,
        ];
    }
}
