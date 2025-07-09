<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'productname'=> fake()-> words(2, true),
            'quantity'=> fake()-> numberBetween(1, 100),
            'price'=> fake()-> randomFloat(2,200,1000),
            'category'=> fake()-> words(1, true),
        ];
    }
}
