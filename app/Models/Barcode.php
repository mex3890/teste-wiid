<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payer_id',
        'valid_until',
        'barcode_value',
        'instruction_1',
        'instruction_2',
        'instruction_3',
        'description',
        'ticket_type',
        'ticket_value',
        'interest_rate_type',
        'interest_rate_value',
        'discount_type',
        'discount_value',
        'discount_limit_date',
        'reference',
        'created_at',
        'updated_at',
    ];
}
