<?php

namespace Database\Factories;

use App\Models\Boat;
use App\Models\BoatModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'boat_model_id' => BoatModel::inRandomOrder()->first()->id,
            'title' => rtrim(fake()->text(rand(8, 21)),'.'),
            'price' => fake()->numberBetween(800, 4000) * 10,
            'condition' => Boat::getConditions()[array_rand(Boat::getConditions())],
            'description' => fake()->text(rand(200, 400)),
            'year' => fake()->numberBetween(2000, now()->year),
            'length' => fake()->randomFloat(99, 3, 9),
            'beam' => fake()->randomFloat(99, 1, 3),
            'fuel_type' => Boat::getFuelTypes()[array_rand(Boat::getFuelTypes())],
            'fuel_capacity' => fake()->numberBetween(10, 60) * 5,
            'horsepower' => fake()->numberBetween(100, 400),
            'number_of_engines' => fake()->numberBetween(1, 3),
            'persons' => fake()->numberBetween(1, 10),
        ];
    }
}
