<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NationalIdCard extends Model
{
    protected $table = 'national_id_cards';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id', 'khmer_id', '','place_of_issue', 'date_of_birth', 'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
