<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;
    public function definition(): array
    {
        return [
           'sku'=>$this->faker->randomNumber(5),
           'title'=>$this->faker->sentence(3),
           'category_id'=>$this->faker->numberBetween(1,5),
           'quantity'=>$this->faker->numberBetween(20,100),
           'image'=>'box.png',
           'unit_price'=>$this->faker->randomNumber(3),
           'discount'=>$this->faker->randomNumber(2),
           'tax_id'=>$this->faker->numberBetween(1,3),
           'status'=>$this->faker->boolean(),
           'stock_notice'=>$this->faker->randomNumber(2),
           'rating'=>$this->faker->numberBetween(1,5)
        ];
    }
}
