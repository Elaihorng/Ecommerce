<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'actor_id', 'action', 'entity_type',
        'entity_id', 'ip_address', 'user_agent', 'metadata'
    ];

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
