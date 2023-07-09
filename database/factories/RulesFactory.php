<?php 

namespace Database\Factories;

use App\Models\Rules;
use Illuminate\Database\Eloquent\Factories\Factory;

class RulesFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rules::class;

    /**
     * Define the model
     */
    public function definition()
    {   
        return [
            'permission' => $this->faker->randomElement(['admin','user'])
        ];
    }
}