<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 500; $i++) {
            Item::create([
                'name' => 'Item ' . Str::random(5),
                'description' => fake()->sentence(),
                'sku' => 'SKU-' . strtoupper(Str::random(8)),
                'quantity' => rand(1, 100),
                'price' => rand(100, 10000) / 100,
                'cost_price' => rand(50, 5000) / 100,
                // Set the expiry_date to a random date within this week or next week
                'expiry_date' => ($date = fake()->optional()->dateTimeBetween(Carbon::now(), Carbon::now()->addWeek())) ? $date->format('Y-m-d') : null,
                'category' => rand(1, 3),
                'image' => null,
                // Generate a random created_at date between 1 year ago and now
                'created_at' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => now(),
            ]);
        }
    }
}
