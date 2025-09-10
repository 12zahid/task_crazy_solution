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
            'name' => $this->faker->word(2,true),
            'description' => $this->faker->paragraph(),
            'price'=>$this->faker->randomFloat(2,10,500),
            'stock'=>$this->faker->numberBetween(2,100),
            'image'=>$this->faker->randomElement(['product_images/404.jpg','product_images/202.jpg','product_images/403.jpg'])
        ];
    }
}
