<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'street' => $this->faker->streetName(),
            'number' => (string) $this->faker->randomNumber($nbDigits = 8, $strict = false),
            'city'   => $this->faker->city(),
            'state'   => 'MG',
            'country' => 'Brazil',
            'postalCode' => '78135-626',
            'user_id'    => User::factory()->create()->id
        ];
    }
}
