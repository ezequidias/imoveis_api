<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $statusOptions = ['available', 'rented', 'sold'];
        $typeOptions = ['house', 'apartment', 'land'];

        return [
            'type' =>  $this->faker->randomElement($typeOptions),
            'address' => $this->faker->address(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'status' =>  $this->faker->randomElement($statusOptions),
        ];
    }
}
