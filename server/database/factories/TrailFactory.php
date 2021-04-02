<?php

namespace Database\Factories;

use App\Models\Trail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class TrailFactory extends Factory
{
    protected $model = Trail::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName . ' Trail',
            'description' => $this->faker->text(512),
        ];
    }
}
