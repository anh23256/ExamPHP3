<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        for ($i=1; $i <= 20 ; $i++) { 
            Product::query()->create([
                'name' => fake()->name,
                'price' => rand(1000,100000),
                'quantity' => rand(1,100),
                'is_active' => rand(0,1),
                'image' => fake()->imageUrl,
            ]);
        }
    }
}
