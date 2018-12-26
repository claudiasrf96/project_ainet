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
        'id', 'state', 'table_number', 'responsible_cook_id'
    ];

    /*public function order()
    {
        return $this->hasMany(Order::class);
    }*/

    public function orders(){
        return $this->hasMany(Order::class , 'meal_id');
    }

    public function users(){
        return $this->hasOne(User::class , 'id', 'responsible_waiter_id');
    }

    public function invoices()
    {
        return $this->belongsTo(Invoice::class);
    }
    
    
/*
    public function tables()
    {
        return $this->hasMany(Table::class);
    }*/
}
