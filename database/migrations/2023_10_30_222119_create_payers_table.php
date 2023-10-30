<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE_NAME = 'payers';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('payer_name');
            $table->string('payer_document');
            $table->string('payer_phone', 15);
            $table->string('payer_email')->unique();
            $table->date('payer_birthday');
            $table->char('payer_address_cep', 8);
            $table->string('payer_address_street');
            $table->string('payer_address_district');
            $table->string('payer_address_number')->nullable();
            $table->text('payer_address_complement')->nullable();
            $table->string('payer_address_city');
            $table->char('payer_address_state', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
