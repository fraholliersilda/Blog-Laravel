<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'paypal_order_id',
        'payer_email',
        'api_key_id',
        'status',
    ];

    public function apiKey()
    {
        return $this->belongsTo(ApiKey::class);
    }
}
