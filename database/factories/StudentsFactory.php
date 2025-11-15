<?php

namespace Database\Factories;

use App\Models\Students;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StudentsFactory extends Factory
{
    protected $model = Students::class;

    public function definition(): array
    {
        return [
            'agent_id' => $this->faker->randomNumber(),
            'bdm_officer_id' => $this->faker->randomNumber(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'middle_name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'gender' => $this->faker->word(),
            'birth_date' => Carbon::now(),
            'country' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
