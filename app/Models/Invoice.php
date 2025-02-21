<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $fillable = [
        'invoice_number',
        'customer_name',
        'due_date',
        'grand_total',
        'items',
        'status',
        'uploadUrl'
    ];

    protected $casts = [
        'items' => 'array'
    ];

    
}
