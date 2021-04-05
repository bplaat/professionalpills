<?php

namespace Database\Factories;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HospitalFactory extends Factory
{
    protected $model = Hospital::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company . ' Hospital',
            'address' => $this->faker->streetAddress,
            'postcode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'country' => $this->faker->randomElement(User::COUNTRIES)
        ];
    }
}
