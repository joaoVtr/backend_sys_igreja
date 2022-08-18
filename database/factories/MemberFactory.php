<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'cpf' => fake()->numerify('###.###.###-##'),
            'birthday' => fake()->date(),
            'email' => fake()->safeEmail(),
            'cell_number' => fake()->numerify('(##)#####-####'),
            'street_name' => fake()->streetName(),
            'city' => fake()->city(),
            'state' => fake()->countryCode(),
        ];
    }
}
