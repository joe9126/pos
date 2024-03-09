<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Supplier;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Supplier::class;
    public function definition(): array
    {
        return [
            'title'=>$this->faker->name(),
            'description'=>$this->faker->sentence(5),
            'telephone'=>$this->faker->phoneNumber(),
            'email'=>$this->faker->email(),
            'address'=>$this->faker->address(),
            'tax_pin'=>$this->faker->randomNumber(5)
        ];
    }
}
