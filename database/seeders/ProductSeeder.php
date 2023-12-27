<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::where('status', 'enable')->get()->each(function ($category) {
            Product::factory()->state(function () use ($category) {
                return [
                    'category_id' => $category->id,
                ];
            })->count(3)->create();
        });
    }
}
