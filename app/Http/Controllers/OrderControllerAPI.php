<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderControllerAPI extends Controller
{

    public function updateState(Request $request, $id)
    {
       $order = Order::findOrFail($id);
       $order->state = $request->input('state');
       $order->update($request->all());
       return new OrderResource($order);
    }

    public function createOrder(Request $request)
    {
        $order = new Order();
        $order->fill($request->all());
        $order->start = Carbon::now();
        $order->save();
        
        $order->update($request->all());
        return new OrderResource($order);
    }
    public function delete(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 204);
    }

    public function getOrders()
    {
        return OrderResource::collection(Order::paginate(7));   
    }

    public function getPreparedOrder($id)
    {
        return OrderResource::collection(Order::where('state', 'prepared')
                                                ->where('responsible_cook_id', $id)->get());  
    }
    public function getPendingConfirmed($id)
    {
        return OrderResource::collection(Order::select('orders.id', 'orders.state', 'item_id', 'meal_id', 'responsible_cook_id', 'orders.start', 'orders.end')
                                                ->from('orders')
                                                ->where('orders.state', 'pending')
                                                ->orWhere('orders.state', 'confirmed')
                                                ->where('responsible_cook_id', $id)
                                                ->join('meals', 'meal_id', '=' , 'meals.id')
                                                ->where('meals.state', 'active')->get());  
    }
    /*public function getOrderDetails( $UserID) 
    {
        return OrderResource::collection(Order::select('orders.id', 'orders.state', 'item_id')
                                                ->from('orders')
                                                ->join('meals', 'meal_id', '=' , 'meals.id')
                                                ->join('items', 'item_id', '=', 'items.id')
                                                ->where('responsible_waiter_id', $UserID)
                                                ->where('meals.state', 'active')->get());  
    }*/
    /*

    public function getPreparedOrders_(Request $request)
    {
        return OrderResource::collection(Order::select('*')->from('orders')
                                                           ->where('state', '=','prepared'));

        //                                                   ->oderByRaw('FIElD(orders.state, "in preparation", "cofirmed")')
        //                                                   ->oderByRaw('orders.start', 'desc');   
                                                           
        //                                                   ->join('users', 'orders.responsible_cook_id', '=', 'users.id')
    }
*/

    public function getActiveOrders(Request $request)
    {
        //return OrderResource::collection(Order::select('*')->from('orders')->where('state', '=','active'));
    }

}
