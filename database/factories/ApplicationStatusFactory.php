<?php

namespace Database\Factories;

use App\Models\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ApplicationStatusFactory extends Factory
{
    protected $model = ApplicationStatus::class;

    public function definition(): array
    {
        return [
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
