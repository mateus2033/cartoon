<?php 

namespace Database\Factories;

use App\Models\Address;
use App\Models\Enterprise;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnterpriseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Enterprise::class;

    /**
     * Define the model
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'fantasy_name' => $this->faker->catchPhrase(),
            'corporate_reason' => $this->faker->companySuffix(),
            'state_registration' => rand(100,999) . '.' .rand(100,999) . '.' . rand(100,999) . '.' . rand(100,999),
            'cnpj' =>  rand(10,99) . '.' . rand(100,999) . '.' . rand(100,999) . '/' .  rand(1000,9999) . '-' .  rand(10,99),
            'municipal_registration' => rand(100,999) . rand(100,999) . rand(100,999) . rand(100,999),
            'responsible' => $this->faker->name(),
            'foundation' => $this->faker->date(),
            'address_id' => Address::factory()->create()->id
        ];
    }
}