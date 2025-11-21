<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCenter extends Model
{
    protected $table = 'test_centers';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'address', 'city', 'contact_phone'];

    public function slots()
    {
        return $this->hasMany(TestSlot::class, 'center_id');
    }
}
