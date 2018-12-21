<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
        return [
            'id' => $this->id,
            'state' => $this->state,
            'table_number' => $this->table_number,
            'start' => $this->start,
            'end' => $this->end,
            'responsible_waiter_id' => $this->responsible_waiter_id,
            'total_price_preview' => $this->total_price_preview,
            'orders' => $this->orders,
            //'orders' => App\Book::with('['author', 'publisher']');
            
            //'orders_name' => $this->orders::with(items);
            //'orders_name' => OrderResource::collection($this->orders),
            'user_table_name' => $this->users->name
        ];
    }
}
