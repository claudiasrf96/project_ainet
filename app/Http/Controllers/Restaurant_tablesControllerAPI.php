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
}
