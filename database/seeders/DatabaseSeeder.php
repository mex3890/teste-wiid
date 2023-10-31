<?php

namespace Database\Seeders;

use App\Models\Barcode;
use App\Models\Payer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create first User with Config credentials
        User::factory()->create(Config::get('database.admin'));

        User::factory(Config::get('database.seeder.users'))->create();
        Payer::factory(Config::get('database.seeder.payers'))->create();
        Barcode::factory(Config::get('database.seeder.barcodes'))->create();
    }
}
