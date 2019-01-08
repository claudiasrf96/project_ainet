<?php

namespace App\Http\Controllers;


use App\Http\Resources\Restaurant_tablesResource;
use Illuminate\Http\Request;
use App\Restaurant_tables;
use Illuminate\Support\Facades\DB;

class Restaurant_tablesControllerAPI extends Controller
{
    
    public function getTables(Request $request)
    {
        return Restaurant_tablesResource::collection(Restaurant_tables::all());   
    }

    public function getTablesFree(Request $request)
    {
        $mesas = Restaurant_tables::all();
        $mesasOcupadas = Restaurant_tables::select( 'restaurant_tables.table_number')
            ->join('meals', 'restaurant_tables.table_number', '=', 'meals.table_number')
            ->where('meals.state', '=', 'active')
            ->get();
        $result = $mesas->pluck('table_number')->diff($mesasOcupadas->pluck('table_number'))
            ->map(function($table_number) {
            return [
                'table_number' => $table_number
            ];
        });
        return $result;
    }
}
