<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = [
            'Front-end', 'Back-end', 'DevOps', 'Full-stack'
        ];
        return [
            'name' => $this->faker->unique()->randomElement($categories),
            
        ];
    }
}
