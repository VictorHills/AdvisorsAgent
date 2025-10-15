<?php

namespace Database\Factories;

use App\Models\StudentApplications;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StudentApplicationsFactory extends Factory
{
    protected $model = StudentApplications::class;

    public function definition(): array
    {
        return [
            'agent_id' => $this->faker->randomNumber(),
            'bdm_officer_id' => $this->faker->randomNumber(),
            'course_id' => $this->faker->randomNumber(),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->word(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'country' => $this->faker->country(),
            'class_of_degree' => $this->faker->word(),
            'additional_notes' => $this->faker->word(),
            'signature' => $this->faker->word(),
            'schools_of_choice' => $this->faker->words(),
            'country_of_preference' => $this->faker->words(),
            'application_documents' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
