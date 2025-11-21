<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Licenses extends Model
{
    protected $table = 'licenses';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id', 'license_type', 'license_number',
        'issued_at', 'expires_at', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'related_license_id');
    }
}
