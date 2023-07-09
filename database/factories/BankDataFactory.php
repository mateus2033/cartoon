<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\BankData;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankDataFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BankData::class;

    /**
     * Define the model
     */
    public function definition()
    {
        return [
            'number_card' => $this->faker->randomNumber($nbDigits = 8, $strict = false),
            'number_agency' =>  $this->faker->randomNumber($nbDigits = 3, $strict = false),
            'number_security' =>  $this->faker->randomNumber($nbDigits = 3, $strict = false),
            'user_id' => User::factory()->create()->id,
            'bank_id' => Bank::factory()->create()->id
        ];
    }
}
