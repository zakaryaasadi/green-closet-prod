<?php

namespace Database\Factories;

use App\Enums\ActiveStatus;
use App\Enums\DaysEnum;
use App\Enums\DischargeShift;
use App\Models\Country;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::factory()->create(['status' => ActiveStatus::INACTIVE])->id,
            'language_id' => Language::factory()->create([
                'code' => 'ar',
            ])->id,
            'default_country_id' => Country::factory()->create(['status' => ActiveStatus::INACTIVE])->id,
            'point_value' => $this->faker->numerify,
            'point_count' => $this->faker->numerify,
            'point_expire' => $this->faker->numerify,
            'first_points' => $this->faker->numerify,
            'first_points_expire' => $this->faker->numerify,
            'container_limit' => $this->faker->numerify,
            'container_value' => $this->faker->numerify,
            'slug' => $this->faker->text,
            'email' => $this->faker->text,
            'location' => $this->faker->text,
            'phone' => $this->faker->text,
            'header_title' => $this->faker->text,
            'header_title_arabic' => $this->faker->text,
            'currency_ar' => $this->faker->text,
            'currency_en' => $this->faker->text,
            'secret_key' => $this->faker->text,
            'auto_assign' => 1,
            'tasks_per_day' => $this->faker->numerify,
            'budget' => $this->faker->numerify,
            'holiday' => DaysEnum::getRandomValue(),
            'start_work' => '12:00',
            'finish_work' => '01:00',
            'work_shift' => DischargeShift::getRandomValue(),
        ];
    }
}
