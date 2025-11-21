<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseType extends Model
{
    protected $table = 'license_types';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['code', 'description', 'min_age'];
}
