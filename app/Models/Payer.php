<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payer_name',
        'payer_document',
        'payer_phone',
        'payer_email',
        'payer_birthday',
        'payer_address_cep',
        'payer_address_street',
        'payer_address_number',
        'payer_address_district',
        'payer_address_complement',
        'payer_address_city',
        'payer_address_state',
        'created_at',
        'updated_at',
    ];
}
