<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meals extends Model
{
    protected $fillable = [
        'state', 'table_number', 'start', 'end', 'responsible_waiter_id', 'total_price_preview', 'created_at', 'updated_at'
    ];
}
