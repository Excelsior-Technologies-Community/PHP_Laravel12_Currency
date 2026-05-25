<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversionHistory extends Model
{
    protected $fillable = [
        'amount',
        'from_currency',
        'to_currency',
        'converted_amount'
    ];
}