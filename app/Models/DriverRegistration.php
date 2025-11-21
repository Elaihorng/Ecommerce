<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'gender',
        'dob',
        'email',
        'phone',
        'license_type',
        'test_center',
        'test_date',
        'national_id',
        'photo',
        'medical_cert',
    ];
}
