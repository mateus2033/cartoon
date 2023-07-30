<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RuleSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
            UserSeeder::class,
            BankSeeder::class
        ]);

       \App\Models\Acquisitions::factory(20)->create();
    }
}
