<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'lastName' => 'admin',
            'cpf' => '979.508.820-34',
            'dataBirth' => '18950505',
            'cellphone' => '279999-9999',
            'image' => 'd043b2065e9ecf6d152a878703b364cc.jpg',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'rule_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'Mateus',
            'lastName' => 'Pereira',
            'cpf' => '883.043.750-60',
            'dataBirth' => '16500112',
            'cellphone' => '2788888-8888',
            'image' => 'd043b2065e9ecf6d152a878703b364cc.jpg',
            'email' => 'mateus@mateus.com',
            'password' => Hash::make('12345678'),
            'rule_id' => 1
        ]);
    }
}
