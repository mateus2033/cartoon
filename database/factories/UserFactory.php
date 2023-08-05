<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Rules;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {  
        return [
            'name'       => $this->faker->name(),
            'lastName'   => $this->faker->lastName(),
            'cpf'        => '792.466.540-48',
            'dataBirth'  => $this->faker->date('d-m-Y'),
            'cellphone'  => $this->faker->phoneNumber(),
            'image'    => '',
            'email'    => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('12345678'),
            'rule_id'  => (int ) Rules::factory()->create()->id
        ];
    }
}
