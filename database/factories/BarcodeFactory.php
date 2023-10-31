<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Config;

class BarcodeFactory extends Factory
{
    /**
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        $random_value = fake()->randomElement([1, 2, 3, 4, 5]);
        $modulo_two = $random_value % 2 === 0;
        $modulo_three = $random_value % 3 === 0;

        return [
            'user_id' => random_int(1, Config::get('database.seeder.users')),
            'payer_id' => random_int(1, Config::get('database.seeder.payers')),
            'valid_until' => fake()->date,
            'barcode_value' => fake()->randomFloat(2, 1, 10000),
            'instruction_1' => $modulo_two ? null : fake()->text,
            'instruction_2' => $modulo_three ? null : fake()->text,
            'instruction_3' => $random_value % 5 === 0 ? null : fake()->text,
            'description' => fake()->text,
            'ticket_type' => $modulo_two ? fake()->randomElement([1, 2]) : null,
            'ticket_value' => $modulo_two ? fake()->randomFloat(2, 1, 10000) : null,
            'interest_rate_type' => $modulo_three ? fake()->randomElement([1, 2]) : null,
            'interest_rate_value' => $modulo_three ? fake()->randomFloat(2, 1, 10000) : null,
            'discount_type' => $modulo_two ? fake()->randomElement([1, 2]) : null,
            'discount_value' => $modulo_two ? fake()->randomFloat(2, 1, 10000) : null,
            'discount_limit_date' => $modulo_two ? fake()->dateTimeBetween('now', '+1 year') : null,
            'reference' => $random_value % 3 === 0 ? fake()->text : null,
            'created_at' => now(),
        ];
    }
}
