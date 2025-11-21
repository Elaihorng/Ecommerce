<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id', 'channel', 'subject', 'body',
        'sent_at', 'status', 'related_entity_type', 'related_entity_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
