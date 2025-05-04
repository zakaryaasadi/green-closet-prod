<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'log_name' => $this->faker->text,
            'description' => $this->faker->text,
            'causer_id' => User::factory()->create()->id,
            'causer_type' => User::factory()->create()->type,
            'subject_id' => News::factory()->create()->id,
            'subject_type' => $this->faker->text,
        ];
    }
}
