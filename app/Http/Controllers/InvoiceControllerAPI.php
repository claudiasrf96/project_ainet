<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\InvoiceResource;
use App\Invoice;

class InvoiceControllerAPI extends Controller
{
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAllInvoices()
    {
        return InvoiceResource::collection(Invoice::paginate(8));
    }

    public function getPendingInvoices()
    {
        return InvoiceResource::collection(Invoice::Select('invoices.date', 'meals.table_number', 'meals.responsible_waiter_id', 
                                            'meals.total_price_preview', 'invoice_items.item_id', 'items.name', 'invoice_items.unit_price',
                                             'invoice_items.sub_total_price')
                                            ->from('invoices')
                                            ->join('invoice_items', 'invoice_id', '=' , 'invoices.id')
                                            ->join('meals', 'meals.id', '=' , 'meal_id')
                                            ->join('items', 'items.id', 'item_id')->paginate(7));
    }

}
