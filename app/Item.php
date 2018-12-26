<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name', 'type', 'description', 'photo_url', 'price', 'deleted_at', 'updated_at', 'created_at' 
    ]; 

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function invoiceItem()
    {
        return $this->belongsTo(InvoiceItem::class);
    }
}
