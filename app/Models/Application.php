<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id', 'application_type', 'requested_license_type',
        'related_license_id', 'processed_by', 'status',
        'submitted_at', 'processed_at', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function license()
    {
        return $this->belongsTo(License::class, 'related_license_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'application_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'application_id');
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'application_id');
    }
}
