<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcquisitionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $count = 0;
        $count++;
        $number = rand(10, 1000);

        $dia = rand(1, 31);
        $mes = rand(1, 12);
        $ano = rand(2022, 2023);
        $data = new DateTime("$ano-$mes-$dia");
        $data = $data->format('Y-m-d');

        return [
            'period' => $data,
            'amount' => $number,
            'product_id' => $count
        ];
    }
}
