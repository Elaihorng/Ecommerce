<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $table = 'test_results';
    protected $primaryKey = 'id';
    public $incrementing = true; // ✅ allow auto-increment IDs
    protected $keyType = 'int'; // ✅ match DB bigint

    protected $fillable = [
        'booking_id',
        'user_id',
        'theory_result',
        'practical_result',
        'remarks',
        'tested_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
