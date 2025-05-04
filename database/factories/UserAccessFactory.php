<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAccessFactory extends Factory
{
    protected $model = UserAccess::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'country_id' => Country::factory()->create()->id,
            'role_id' => Role::factory()->create()->id,
        ];
    }
}
