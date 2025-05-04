<?php

namespace Database\Factories;

use App\Models\Association;
use App\Models\Country;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssociationFactory extends Factory
{
    protected $model = Association::class;

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
            'description' => $this->faker->text(200),
            'url' => $this->faker->url(),
            'country_id' => Country::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'meta' => [
                'translate' => [
                    'title_en' => $this->faker->title() . '_en',
                    'description_en' => $this->faker->text(100) . '_en',
                ],
            ],
        ];
    }
}
