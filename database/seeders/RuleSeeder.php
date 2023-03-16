<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rules')->insert([
            'permission' => 'admin'
        ]);

        DB::table('rules')->insert([
            'permission' => 'user'
        ]);

    }
}
