<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'application_id', 'user_id', 'slot_id',
        'test_type', 'status', 'booked_at', 'attended_at', 'result_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function slot()
    {
        return $this->belongsTo(TestSlot::class, 'slot_id');
    }

    public function testResult()
    {
        return $this->hasOne(TestResult::class, 'booking_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function testCenter()
    {
        return $this->belongsTo(TestCenter::class, 'test_center_id');
    }


}
