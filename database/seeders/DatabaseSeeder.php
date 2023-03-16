<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            RuleSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
            UserSeeder::class
        ]);

        \App\Models\Acquisitions::factory(20)->create();
    }
}