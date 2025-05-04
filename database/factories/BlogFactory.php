<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

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
            'description' => $this->faker->text(100),
            'image' => $this->faker->url,
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
