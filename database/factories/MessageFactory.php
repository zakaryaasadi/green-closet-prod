<?php

namespace Database\Factories;

use App\Enums\MessageType;
use App\Models\Country;
use App\Models\Language;
use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $language = Language::factory()->create(['code' => 'ar']);

        return [
            'content' => $this->faker->text(100),
            'country_id' => Country::factory()->create()->id,
            'type' => MessageType::getRandomValue(),
            'language_id' => $language->id,
        ];
    }
}
