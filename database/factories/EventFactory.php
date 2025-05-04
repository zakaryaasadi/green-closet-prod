<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Event;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

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
            'description' => $this->faker->text('255'),
            'date' => $this->faker->dateTime->format('Y-m-d H:i:s'),
            'country_id' => Country::factory()->create()->id,
            'meta' => [
                'translate' => [
                    'title_en' => 'title_en',
                    'description_en' => 'description_en',
                ],
            ],
        ];
    }
}
