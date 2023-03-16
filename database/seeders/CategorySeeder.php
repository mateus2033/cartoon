<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'papelaria',
            'description'  =>  'is simply dummy text of the printing and typesetting',
        ]);

        DB::table('categories')->insert([
            'name' => 'perfumaria',
            'description'  =>  'is simply dummy text of the printing and typesetting',
        ]);

        DB::table('categories')->insert([
            'name' => 'verstiario',
            'description'  =>  'is simply dummy text of the printing and typesetting',
        ]);
    }
}
