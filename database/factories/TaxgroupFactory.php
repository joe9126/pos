<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Taxgroup;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaxgroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Taxgroup::class;
    public function definition(): array
    {
        return [
            'title'=>$this->faker->sentence(1),
            'rate'=>$this->faker->numberBetween(12,20),
            'status'=>$this->faker->boolean()

        ];
    }
}
