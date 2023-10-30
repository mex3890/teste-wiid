<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE_NAME = 'barcodes';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('payer_id')->constrained();
            $table->date('valid_until');
            $table->float('barcode_value');
            $table->text('instruction_1')->nullable();
            $table->text('instruction_2')->nullable();
            $table->text('instruction_3')->nullable();
            $table->text('description');
            $table->enum('ticket_type', [1, 2])->nullable();
            $table->float('ticket_value')->nullable();
            $table->enum('interest_rate_type', [1, 2])->nullable();
            $table->float('interest_rate_value')->nullable();
            $table->enum('discount_type', [1, 2])->nullable();
            $table->float('discount_value')->nullable();
            $table->date('discount_limit_date')->nullable();
            $table->text('reference')->nullable();
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
