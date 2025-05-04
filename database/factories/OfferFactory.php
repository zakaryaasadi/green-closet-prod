<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Language;
use App\Models\Offer;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class OfferFactory extends Factory
{
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        Language::factory()->create(['code' => 'ar']);

        return [
            'name' => $this->faker->name(),
            'value' => $this->faker->numberBetween(1, 1000),
            'meta' => [
                'translate' => [
                    'name_ar' => 'name_ar',
                ],
            ],
            'country_id' => Country::factory()->create()->id,
            'partner_id' => Partner::factory()->create()->id,
        ];


    }
}
