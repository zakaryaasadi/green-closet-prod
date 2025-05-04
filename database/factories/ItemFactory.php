<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Item;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        Language::factory()->create(['code' => 'ar']);

        return [
            'title' => $this->faker->name(),
            'image_path' => $this->faker->url,
            'price_per_kg' => $this->faker->numberBetween(1, 200),
            'meta' => [
                'translate' => [
                    'title_ar' => 'title_ar',
                    'title_en' => 'title_en',
                ],
            ],
            'country_id' => Country::factory()->create()->id,
        ];


    }
}
