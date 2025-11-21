<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestSlot extends Model
{
    protected $table = 'test_slots';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'center_id', 'slot_date', 'start_time', 'end_time', 'capacity'
    ];

    public function center()
    {
        return $this->belongsTo(TestCenter::class, 'center_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'slot_id');
    }
}
