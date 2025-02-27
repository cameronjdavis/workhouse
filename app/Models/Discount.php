<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    const DISCOUNT_TYPE_FIXED = 'fixed';
    const DISCOUNT_TYPE_PERCENTAGE = 'percentage';

    protected $fillable = [
        'discount_type',
        'amount',
        'active_from',
        'active_to',
    ];
}
