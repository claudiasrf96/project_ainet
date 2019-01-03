<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id', 'item_id', 'quantity', 'unit_price', 'sub_total_price'
    ];

    public function invoices()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function items(){
        return $this->hasOne(Item::class , 'id', 'item_id');
    }
}
