<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'expiry_date',
        'max_uses',
        'uses_count'
    ];

    protected $casts = [
        'discount_value' => 'float',
        'max_uses' => 'integer',
        'uses_count' => 'integer'
    ];
}
