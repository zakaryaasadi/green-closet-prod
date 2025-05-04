<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Language;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        Language::factory()->create(['code' => 'en']);

        return [
            'title' => $this->faker->title(),
            'link' => $this->faker->url,
            'description' => $this->faker->text(100),
            'display_order' => $this->faker->unique()->randomNumber(),
            'thumbnail' => $this->faker->url,
            'country_id' => Country::factory()->create()->id,
            'meta' => [
                'translate' => [
                    'title_en' => $this->faker->title() . '_en',
                    'description_en' => $this->faker->text(100) . '_en',
                ],
            ],
        ];
    }
}
