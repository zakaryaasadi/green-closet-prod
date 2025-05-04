<?php

namespace Database\Factories;

use App\Enums\MediaType;
use App\Models\Country;
use App\Models\MediaModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaModelFactory extends Factory
{
    protected $model = MediaModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'media' => $this->faker->name . '.' . $this->faker->fileExtension(),
            'tag' => $this->faker->title,
            'country_id' => Country::factory()->create()->id,
            'type' => MediaType::IMAGE,

        ];
    }
}
