<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'route_name', 'description','is_active'];
}

