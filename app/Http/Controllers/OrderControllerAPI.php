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

    public function updateStateToNotDelivers(Request $request, $id)
    {
        $order = Order::findOrFail($id);
            if ($order->state != 'deliverd') {
                $order->state = $request->input('state');
            }
        $order->update($request->all());
        return new OrderResource($order);
    }
/*
    public function createInvoice(Request $request, $id)
    {
        $invoice = new Invoice();
        $invoice->state = 'pending';
        $invoice->meal_id = '1';
        $invoice->date = Carbon::now();

        OrderResource::collection(Order::where('meal_id', "1"))

                                                
        $order->update($request->all());
        return new OrderResource($order);
    }
*/
    

    public function createOrder(Request $request)
    {
        $order = new Order();
        $order->state = $request->input('state');
        $order->item_id = $request->input('item_id');
        $order->meal_id = $request->input('meal_id');
        $order->responsible_cook_id = $request->input('responsible_cook_id');
        $order->start = Carbon::now()->toDateTimeString();
        $order->save();
        
        return new OrderResource($order);
    }
    public function delete(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, 204);
    }

    public function getOrders(Request $request)
    {
        return OrderResource::collection(Order::orderBy('start', 'desc')->paginate($request->get('page_size')));   
    }

    public function getConfirmedInPreprationCook(Request $request, $id) //U9
    {
        return OrderResource::collection(Order::where('orders.state', 'confirmed')
                                                ->orWhere(function($query) use ($id) {
                                                    $query->where('orders.state', 'in preparation')
                                                        ->where('orders.responsible_cook_id', $id);
                                                })
                                                ->orderByRaw("FIELD('in preparation' , 'confirmed')", 'desc')
                                                
                                                ->orderBy('start', 'desc')
                                                ->paginate($request->get('page_size')));  
    }

    public function getPendingConfirmedWaiter(Request $request, $id) //U14
    {
        return OrderResource::collection(Order::select('orders.*')
                                                ->where('orders.state', 'pending')
                                                ->orWhere('orders.state', 'confirmed')
                                                ->where('responsible_waiter_id', $id)
                                                ->join('meals', 'meal_id', '=' , 'meals.id')
                                                ->where('meals.state', 'active')->paginate($request->get('page_size')));  
    }
    
    public function getPreparedOrder(Request $request, $id) //U17
    {
        return OrderResource::collection(Order::select('orders.*')
                                                ->where('orders.state', 'prepared')
                                                ->join('meals', 'meal_id', '=' , 'meals.id')
                                                ->where('responsible_waiter_id', $id)->paginate($request->get('page_size')));  
    }
   
    public function getPendingConfirmed(Request $request, $id)
    { //select('orders.id', 'orders.state', 'item_id', 'meal_id', 'responsible_cook_id', 'orders.start', 'orders.end')->from('orders')
        return OrderResource::collection(Order::where('orders.state', 'pending')
                                                ->orWhere('orders.state', 'confirmed')
                                                ->where('responsible_cook_id', $id)
                                                ->join('meals', 'meal_id', '=' , 'meals.id')
                                                ->where('meals.state', 'active')->paginate($request->get('page_size')));  

                                                
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
