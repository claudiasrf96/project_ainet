<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'invoice_id' => $this->invoice_id,
            'item_id' => $this->item_id,
            'items' => $this->items,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'suv:total_price' => $this->sub_total_price,
        ];
    }
}
