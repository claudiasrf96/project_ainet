<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\DB;

class OrderControllerAPI extends Controller
{

    public function update(Request $request, $id)
    {
       $order = Order::findOrFail($id);
       $order->update($request->all());
       return new OrderResource($order);
    }

    public function getOrders(Request $request)
    {
        return OrderResource::collection(Order::paginate(200));   
    }
}
