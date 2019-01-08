<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\InvoiceItemResource;
use App\InvoiceItem;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MealResource;
use App\Meal;

 /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
class InvoiceItemControllerAPI extends Controller
{

    public function getAllinvoiceItems()
    {
        return InvoiceItemResource::collection(InvoiceItem::paginate(5)); 
    }

    public function createInvoiceItems(Request $request, $id)
    {
        $meal = Meal::findOrFail($id);
        $dups = array();
        //items das orders
        foreach($meal->orders as $val){


            $id = $val->items->id. "";

            if( ! isset( $dups[$id] ) )
            {
                $dups[$id] = [
                    'count' => 1,
                    'price' => $val->items->price
                ];
            }
            else{
                $dups[$id]['count']++;
            }
        }  
        
       // $invoicesItemsColection = array();
       
        $invoice_item = new InvoiceItem();
        foreach($dups as $key => $val){
            $invoice_item->item_id = $key; 
            $invoice_item->invoice_id = $meal->id;
            $invoice_item->unit_price = $val['price'];
            $invoice_item->quantity = $val['count'];
            $invoice_item->sub_total_price = ($val['count'] *  $val['price']);
            $invoice_item->save();
        }
        return  new InvoiceItem();
        //return InvoiceItemResource::collection($invoicesItemsColection);
        

          
    }

}
