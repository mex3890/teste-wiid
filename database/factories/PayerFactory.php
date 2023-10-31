<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class PayerFactory extends Factory
{
    /**
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'user_id' => random_int(1, Config::get('database.seeder.users')),
            'payer_name' => fake()->name,
            'payer_document' => Storage::url('temp-barcodes/test_barcode.pdf'),
            'payer_phone' => fake()->randomNumber(5) . fake()->randomNumber(6),
            'payer_email' => fake()->unique()->safeEmail,
            'payer_birthday' => fake()->date,
            'payer_address_cep' => fake()->randomNumber(8),
            'payer_address_street' => fake()->streetName,
            'payer_address_district' => fake()->citySuffix,
            'payer_address_number' => fake()->randomNumber(3),
            'payer_address_complement' => fake()->randomNumber(1) % 2 === 0 ? fake()->text() : null,
            'payer_address_city' => fake()->city,
            'payer_address_state' => strtoupper(fake()->randomLetter() . fake()->randomLetter()),
            'created_at' => now(),
        ];
    }
}
