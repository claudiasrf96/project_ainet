<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealResource;
use Illuminate\Http\Request;
use App\Meal;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MealControllerAPI extends Controller
{
    
    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function store(Request $request)
    {
        $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'username' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' => 'required|email|unique:users,email',
                'password' => 'min:3'
            ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json(new UserResource($user), 201);
    }

    public function createMeal(Request $request)
    {
        $meal = new Meal();
        $meal->state = "active";
        $meal->responsible_waiter_id = $request->input('responsible_waiter_id');
        $meal->table_number = $request->input('table_number');
        $meal->start = Carbon::now();

        $meal->save();
        
        //$meal->update($request->all());
        return new MealResource($meal);
    }

    public function update(Request $request, $id)
    {
       $meal = Meal::findOrFail($id);
       $meal->state = $request->input('state');
       return new MealResource($meal);
    }

    public function getMeals()
    {
       // return MealResource::collection(Meal::where('state', 'active')->get()); 
       // return MealResource::collection(Meal::all()); //paginate(7));   
       return MealResource::collection(Meal::with('orders.items')->get()); 
    }
    public function getActiveMealWithOpenOrder(Request $request , $id)
    {
        return MealResource::collection(Meal::where('meals.state', 'active')
                                            ->where('responsible_waiter_id', $id)
                                            ->where('orders.state','!=', 'delivered')->get()); 
                                            /*:select('meals.id', 'meals.state', 'table_number', 'meal_id', 'responsible_waiter_id', 'meals.start', 'meals.end')
                                            ->from('meals')
                                            ->where('state', 'active')
                                            ->where('responsible_waiter_id', $id)
                                            ->join('orders', 'id', '=' , 'meal_id')
                                            ->where('orders.state','!=', 'delivered')); */ 
    }
    public function getActiveMeal( $id)
    {
        return MealResource::collection(Meal::where('state', 'active')
                                            ->where('responsible_waiter_id', $id)->get());  
    }

   
}
