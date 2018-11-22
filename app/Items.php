<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = [
        'name', 'type', 'description', 'photo_url', 'price', 'deleted_at', 'updated_at', 'created_at' 
    ]; 
}
