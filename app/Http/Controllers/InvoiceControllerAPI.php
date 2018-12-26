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
        $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'nif' => 'required|integer|min:9,'
            ]);
        $invoice = Invoice::findOrFail($id);
        $invoice->fill($request->all());
        $invoice->save();
        return new InvoiceResource($invoice);
    }

    public function getAllInvoices(Request $request)
    { 
        $invoices = Invoice::where('state', 'pending')->with('meals.users')->paginate($request->get('page_size'));
        return InvoiceResource::collection($invoices);
        //return InvoiceResource::collection($invoices);
    }

    public function getDetailInfoAboutInvoices(Request $request)
    {
        $invoices = Invoice::with('invoiceItems.items')->with('meals.users')->paginate($request->get('page_size'));

        return InvoiceResource::collection($invoices);
    }

    public function getPendingInvoices()
    {
        $invoices = Invoice::where('state', 'pending')->paginate(10);
        return InvoiceResource::collection($invoices);
    }

}
