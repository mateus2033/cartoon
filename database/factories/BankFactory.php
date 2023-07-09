<?php

namespace Database\Factories;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bank::class;

    /**
     * Define the model
     */
    public function definition()
    {
        return [
           'code' => $this->faker->randomElement(['515', '721', '535', '714']),
           'name' => $this->faker->randomElement(['Itau', 'Bradesco']),
           'active' => $this->faker->randomElement(['Y', 'N'])
        ];
    }
}
