<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\InvoiceItemResource;
use App\InvoiceItem;

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

}
