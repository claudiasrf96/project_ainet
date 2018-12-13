<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant_tables extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'table_number'
    ];
}
