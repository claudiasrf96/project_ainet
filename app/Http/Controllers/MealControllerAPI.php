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
        $meal->total_price_preview = $request->input('total_price_preview');
        $meal->table_number = $request->input('table_number');
        $meal->start = Carbon::now();

        $meal->save();
        
        $meal->update($request->all());
        return new MealResource($meal);
    }

    public function update(Request $request, $id)
    {
       $meal = Meal::findOrFail($id);
       $meal->state = $request->input('state');
       $meal->table_number = 0;
       return new MealResource($meal);
    }

    public function getMeals(Request $request)
    {
        return MealResource::collection(Meal::all());   
    }
}
