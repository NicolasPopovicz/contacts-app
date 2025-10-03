<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'    => Auth::user()->id,
            'name'       => fake()->name(),
            'cpf'        => (string) fake()->unique()->numberBetween(10000000000, 99999999999),
            'phone'      => (string) fake()->unique()->numberBetween(10000000000, 99999999999),
            'address'    => fake()->streetName(),
            'complement' => fake()->optional(0.5)->realTextBetween(10, 30),
            'cep'        => (string) fake()->unique()->numberBetween(10000000, 99999999),
            'number'     => (string) fake()->unique()->numberBetween(1000, 9999),
            'city'       => fake()->city(),
            'state'      => fake()->stateAbbr(),
            'latitude'   => (string) fake()->latitude(),
            'longitude'  => (string) fake()->longitude(),
        ];
    }
}
