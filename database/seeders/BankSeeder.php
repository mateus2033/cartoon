<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->insert([
            'code'   => '337',
            'name'   => 'Sicoob',
            'active' => 'Y'
        ]);

        DB::table('banks')->insert([
            'code'   => '741',
            'name'   => 'Inter',
            'active' => 'Y'
        ]);

        DB::table('banks')->insert([
            'code'   => '356',
            'name'   => 'Master',
            'active' => 'Y'
        ]);
    }
}
