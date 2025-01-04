<?php

namespace Database\Factories;

use App\Models\OTP;
use Illuminate\Database\Eloquent\Factories\Factory;

class OTPFactory extends Factory
{
    protected $model = OTP::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->email(),
            'otp' => $this->faker->randomNumber(),
            'expires_at' => $this->faker->dateTime(),
        ];
    }
}
