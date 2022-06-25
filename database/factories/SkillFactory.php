<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $skills = [
            'Vue', 'React', 'jQuery', 
            'Laravel', 'Django', 'PHP',
            'Git', 'Docker'
        ];
        return [
            'name' => $this->faker->unique()->randomElement($skills),

        ];
    }
}
