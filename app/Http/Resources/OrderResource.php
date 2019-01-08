<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        
        return [
            'id' => $this->id,
            'state' => $this->state,
            'item_id' => $this->item_id,
            'items' => $this->items,
            'responsible_cook_id' => $this->responsible_cook_id,
            'start' => $this->start,
            'end' => $this->end,
            'meal_id' => $this->meal_id,
            'meal_table_id' => $this->meal->id,
            'meal_table_state' => $this->meal->state,
            "responsible_cook_name" => $this->users != null ? $this->users->name : ""
        ];
    }
}
