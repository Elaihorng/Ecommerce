<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseRenewal extends Model
{
    protected $fillable = [
        'application_id',
        'user_id',
        'license_id',
        'national_id',
        'permit_number',
        'reference',
        'current_license_number',
        'delivery_option',
        'delivery_address',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
    public function license()
    {
        // if your foreign key is license_id, this is enough
        return $this->belongsTo(Licenses::class);
    }
}
