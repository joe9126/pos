<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    //protected $model = Settings::class;
    public function definition(): array
    {
        return [
          'store_name'=>$this->faker->name." Stores",
            'slogan'=>$this->faker->sentence(3),
            'address'=>$this->faker->address,
            'telephone'=>$this->faker->phoneNumber,
            'email'=>$this->faker->email,
            'low_stock_level'=>$this->faker->numberBetween(10,15),
       
        ];
    }
}
