<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Language;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        Language::factory()->create(['code' => 'ar']);

        return [
            'name' => $this->faker->title(),
            'description' => $this->faker->text(100),
            'image_path' => $this->faker->url,
            'country_id' => Country::factory()->create()->id,
            'url' => $this->faker->url,
            'meta' => [
                'translate' => [
                    'title_ar' => $this->faker->title() . '_ar',
                    'description_ar' => $this->faker->text(100) . '_ar',
                ],
            ],
        ];
    }
}
