<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state', 'item_id', 'meal_id', 'responsible_cook_id', 'start', 'end', 'created_at', 'updated_at'
    ];
}
