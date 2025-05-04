<?php

namespace Database\Factories;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Propaganistas\LaravelPhone\Exceptions\NumberParseException;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->validPhoneNumber('AE'),
            'email_verified_at' => now(),
            'password' => 'secret',
            'country_id' => 1,
            'remember_token' => Str::random(10),
            'type' => UserType::CLIENT,
        ];
    }

    public function validPhoneNumber($countryCode): string
    {
        $result = null;

        do {
            $fakePhone = $this->faker->phoneNumber;
            try {
                $fakePhone = new PhoneNumber($fakePhone, $countryCode);
                $result = $fakePhone->formatE164();
            } catch (NumberParseException $e) {
            }
        } while (!$result);

        return $result;
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
