<?php

namespace Database\Factories;

use App\Enums\IpStatus;
use App\Models\IP;
use Illuminate\Database\Eloquent\Factories\Factory;

class IPFactory extends Factory
{
    protected $model = IP::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'ip_address' => $this->faker->ipv6,
            'status' => IpStatus::getRandomValue(),
        ];
    }
}
