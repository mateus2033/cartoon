<?php 

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory 
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(100),
            'description' => $this->faker->text(150),
        ];
    }
}