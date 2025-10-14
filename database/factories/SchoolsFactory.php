<?php

namespace Database\Factories;

use App\Models\Schools;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SchoolsFactory extends Factory
{
    protected $model = Schools::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'full_address' => $this->faker->address(),
            'postal_code' => $this->faker->postcode(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'image' => $this->faker->word(),
            'code' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
