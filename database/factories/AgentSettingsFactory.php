<?php

namespace Database\Factories;

use App\Enums\DaysEnum;
use App\Enums\DischargeShift;
use App\Models\AgentSettings;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentSettingsFactory extends Factory
{
    protected $model = AgentSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        Language::factory()->create(['code' => 'en']);

        return [
            'agent_id' => User::factory()->create()->id,
            'start_work' => $this->faker->dateTimeBetween('now', '+20 years')->format('Y-m-d H:i:s '),
            'finish_work' => $this->faker->dateTimeBetween('now', '+20 years')->format('Y-m-d H:i:s '),
            'tasks_per_day' => $this->faker->numerify(),
            'budget' => $this->faker->numerify(),
            'holiday' => DaysEnum::FRIDAY,
            'work_shift' => DischargeShift::EVENING_SHIFT,


        ];
    }
}
