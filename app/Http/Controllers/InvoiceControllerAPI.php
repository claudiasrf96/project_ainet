<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\InvoiceResource;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function createInvoice(Request $request)
    {
        $invoice = new Invoice();
        $invoice->state = $request->input('state');
        $invoice->meal_id = $request->input('meal_id');
        $invoice->date = Carbon::now()->toDateString();
        $invoice->total_price = $request->input('total_price');
        $invoice->save();
        return new InvoiceResource($invoice);
    }

   /* public function getInvoice(Request $request)
    { 
        
        $invoices = Invoice::where('state', 'pending')->with('meals.users')->paginate($request->get('page_size'));
        if($request->input('date') != null ){
            $invoices = Invoice::where('date', $request->input('date'))->with('meals.users')->paginate($request->get('page_size'));
        }else if ($request->input('waiter') != null) {
            $invoices = Invoice::join('users', 'meals.id', '=' , 'orders.meal_id')where('date', $request->input('date'))->with('meals.users')->paginate($request->get('page_size'));
        }
        return InvoiceResource::collection($invoices);
        //return InvoiceResource::collection($invoices);
    }*/

    public function getAllInvoices(Request $request)
    { 
        $invoices = Invoice::where('state', 'pending')->with('meals.users')->paginate($request->get('page_size'));
        return InvoiceResource::collection($invoices);
        //return InvoiceResource::collection($invoices);
    }

    public function getAllInvoicesInfoManager(Request $request)
    { 
        $invoices = Invoice::where('state', 'pending')->with('meals.orders')->with('meals.users')->paginate($request->get('page_size'));
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

    public function getPaidInvoices(Request $request)
    {
        $invoices = Invoice::where('state', 'paid')->with('meals.users')->paginate($request->get('page_size'));
        return InvoiceResource::collection($invoices);
    }

    public function getMealInvoice($id)
    {
        $invoices = Invoice::where('meal_id', $id)->paginate(15);
        return InvoiceResource::collection($invoices);
    }

    

}
