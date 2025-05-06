<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 1000; $i++) {
            Item::create([
                'name' => 'Item ' . Str::random(5),
                'description' => fake()->sentence(),
                'sku' => 'SKU-' . strtoupper(Str::random(8)),
                'quantity' => rand(1, 100),
                'price' => rand(100, 10000) / 100,
                'cost_price' => rand(50, 5000) / 100,
                'expiry_date' => ($date = fake()->optional()->dateTimeBetween('+1 month', '+2 years')) ? $date->format('Y-m-d') : null,
                'category' => rand(1, 3), // Match select input values
                'image' => null,
            ]);
        }
    }
    
}
