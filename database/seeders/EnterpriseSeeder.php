<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('enterprises')->insert([
            'name' => 'Valaquia Shoop',
            'fantasy_name' => 'ALB Mania',
            'corporate_reason' => 'ALB',
            'state_registration' => '321.123.654.789',
            'cnpj' => '50.771.305/0001-75',
            'municipal_registration' => '54654657489',
            'responsible' => 'Jordan Smite',
            'foundation' => '18750505'
        ]);
    }
}
