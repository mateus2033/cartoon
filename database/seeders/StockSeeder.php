<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->insert([
            'stock_min'     => 200,
            'stock_max'     => 1000,
            'stock_current' => 1000,
            'product_id'    => 1
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 400,
            'stock_max'     => 1500,
            'stock_current' => 1500,
            'product_id'    => 2
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 2000,
            'stock_max'     => 5000,
            'stock_current' => 5000,
            'product_id'    => 3
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 400,
            'stock_max'     => 1500,
            'stock_current' => 1500,
            'product_id'    => 4
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 2000,
            'stock_max'     => 5000,
            'stock_current' => 5000,
            'product_id'    => 5
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 200,
            'stock_max'     => 1000,
            'stock_current' => 1000,
            'product_id'    => 6
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 400,
            'stock_max'     => 1500,
            'stock_current' => 1500,
            'product_id'    => 7
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 2000,
            'stock_max'     => 5000,
            'stock_current' => 5000,
            'product_id'    => 8
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 400,
            'stock_max'     => 1500,
            'stock_current' => 1500,
            'product_id'    => 9
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 2000,
            'stock_max'     => 5000,
            'stock_current' => 5000,
            'product_id'    => 10
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 200,
            'stock_max'     => 1000,
            'stock_current' => 1000,
            'product_id'    => 11
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 400,
            'stock_max'     => 1500,
            'stock_current' => 1500,
            'product_id'    => 12
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 2000,
            'stock_max'     => 5000,
            'stock_current' => 5000,
            'product_id'    => 13
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 400,
            'stock_max'     => 1500,
            'stock_current' => 1500,
            'product_id'    => 14
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 2000,
            'stock_max'     => 5000,
            'stock_current' => 5000,
            'product_id'    => 15
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 200,
            'stock_max'     => 1000,
            'stock_current' => 1000,
            'product_id'    => 16
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 400,
            'stock_max'     => 1500,
            'stock_current' => 1500,
            'product_id'    => 17
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 2000,
            'stock_max'     => 5000,
            'stock_current' => 5000,
            'product_id'    => 18
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 400,
            'stock_max'     => 1500,
            'stock_current' => 1500,
            'product_id'    => 19
        ]);

        DB::table('stocks')->insert([
            'stock_min'     => 2000,
            'stock_max'     => 5000,
            'stock_current' => 5000,
            'product_id'    => 20
        ]);
    }
}
