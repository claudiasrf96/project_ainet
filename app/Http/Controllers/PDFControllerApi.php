<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

use Illuminate\Support\Facades\DB;
use App\Http\Resources\InvoiceResource;
use App\Invoice;
use App\Http\Resources\ItemsResource;
use App\Item;

class PDFControllerApi extends Controller
{
    function index($id)
    {
     $invoice_data = $this->get_invoice_data($id);
     return view('dynamic_pdf')->with('invoice_data', $invoice_data);
    }

    function get_invoice_data($id)
    {
        $invoices = Invoice::where('id', $id)->get();
        return $invoices;
    }

    function get_item_data_manager($id)
    {
        $item = Item::where('id', $id)->get();
        return $item;
    }


    function getPdf($id)
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_invoice_data_to_html($id));
     return $pdf->stream("invoice.pdf");
    }

    function getPdfManager($id)
    {
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($this->convert_item_data_to_html_manager($id));
     return $pdf->stream("order.pdf");
    }
    

    function convert_invoice_data_to_html($id)
    {
     $invoice_data = $this->get_invoice_data($id);
     $output = '

     <h3 align="center">Invoice Data</h3>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
        <th style="border: 1px solid; padding:12px;" width="20%">Id</th>
        <th style="border: 1px solid; padding:12px;" width="30%">State</th>
        <th style="border: 1px solid; padding:12px;" width="15%">Meal ID</th>
        <th style="border: 1px solid; padding:12px;" width="15%">Nif Code</th>
        <th style="border: 1px solid; padding:12px;" width="20%">Name</th>
        <th style="border: 1px solid; padding:12px;" width="20%">Date</th>
        <th style="border: 1px solid; padding:12px;" width="20%">Total Price</th>
     </tr>
     ';  
     foreach($invoice_data as $invoice)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:12px;">'.$invoice->id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$invoice->state.'</td>
       <td style="border: 1px solid; padding:12px;">'.$invoice->meal_id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$invoice->nif.'</td>
       <td style="border: 1px solid; padding:12px;">'.$invoice->name.'</td>
       <td style="border: 1px solid; padding:12px;">'.$invoice->date.'</td>
       <td style="border: 1px solid; padding:12px;">'.$invoice->total_price.'</td>
      </tr>
      ';
     }
     $output .= '</table>';
     return $output;
    }

    
    function convert_item_data_to_html_manager($id)
    {
     $item_data = $this->get_item_data_manager($id);
     $output = '

     <h3 align="center">Invoice Data</h3>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
        <th style="border: 1px solid; padding:12px;" width="20%">Id</th>
        <th style="border: 1px solid; padding:12px;" width="30%">State</th>
        <th style="border: 1px solid; padding:12px;" width="15%">Meal ID</th>
        <th style="border: 1px solid; padding:12px;" width="15%">Nif Code</th>
        <th style="border: 1px solid; padding:12px;" width="20%">Name</th>
        <th style="border: 1px solid; padding:12px;" width="20%">Date</th>
        <th style="border: 1px solid; padding:12px;" width="20%">Total Price</th>
     </tr>
     ';  
     foreach($item_data as $item)
     {
      $output .= '
      <tr>
       <td style="border: 1px solid; padding:12px;">'.$item->id.'</td>
       <td style="border: 1px solid; padding:12px;">'.$item->name.'</td>
       <td style="border: 1px solid; padding:12px;">'.$item->type.'</td>
       <td style="border: 1px solid; padding:12px;">'.$item->description.'</td>
      </tr>
      ';
     }
     $output .= '</table>';
     return $output;
    }
}
