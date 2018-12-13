<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state', 'table_number', 'responsible_cook_id', 'total_price_preview' 
    ];
}
