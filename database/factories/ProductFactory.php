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
            'name' => 'a '.fake()->name(),
            'description' => 'a '.fake()->text(),
            'product_attr' => [
                'sku' => fake()->ean8(),
                'color' => fake()->colorName(),
                'price' => fake()->randomFloat(2, 100, 200),
                'price_ex_vat' => fake()->randomFloat(2, 201, 250),
                'weight' => rand(10, 20)." kg.",
                'dimension' => rand(10, 100)." x ".rand(10, 100)." x ".rand(10, 100)." mm",
                'variant' => fake()->word(),
            ],
            'product_img' => null,
            'amount' => rand(50, 100),
            'warranty' => rand(1, 3)." Year",
            'remark' => fake()->word(),
            'type' => implode(',', fake()->randomElements(['instock', 'preorder'])),
            'status' => implode(',', fake()->randomElements(['enable', 'disable'])),
        ];
    }
}
