<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'state', 'nif', 'name', 'total_price', 'created_at', 'updated_at' 
    ];
    
    public function meals(){
        return $this->hasOne(Meal::class , 'id', 'meal_id');
    }

    public function invoiceItems(){
        return $this->hasMany(InvoiceItem::class , 'invoice_id', 'id');
    }
}
