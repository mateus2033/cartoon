<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name'   => 'Caderno 10 materias',
            'price'  => 15.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno 20 materias',
            'price'  => 19.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Argenda',           
            'price'  => 5.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno 20 materias',
            'price'  => 17.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno 15 materias blue',
            'price'  => 9.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Argenda Lara Kent',
            'price'  => 8.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno 1 materia red',
            'price'  => 5.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno de anotações 1 materia',
            'price'  => 3.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno 1 materia Capa Dura',
            'price'  => 5.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno 15 ben 10',
            'price'  => 9.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Argenda Hello kit',
            'price'  => 5.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno personalisado 1',
            'price'  => 11.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno personalisado 2',
            'price'  => 11.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno personalisado 3',
            'price'  => 11.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno personalisado 4',
            'price'  => 9.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Argenda Theme My Ocean',
            'price'  => 5.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno Theme Verde',
            'price'  => 11.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno Theme Person',
            'price'  => 12.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno personalisado 6',
            'price'  => 2.99,
            'category_id' => 1
        ]);

        DB::table('products')->insert([
            'name'   => 'Caderno personalisado 7',
            'price'  => 19.99,
            'category_id' => 1
        ]);
    }
}
