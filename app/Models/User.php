<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $hidden = ['password_hash', 'remember_token'];
    protected $fillable = [
        'gender','email', 'dob','phone', 'password_hash', 'full_name',
        'preferred_language', 'is_active', 'last_login_at'
    ];

    public function setPasswordHashAttribute($value)
    {
        // Only hash if it's not already hashed
        if (!empty($value) && !\Illuminate\Support\Str::startsWith($value, '$2y$')) {
            $this->attributes['password_hash'] = bcrypt($value);
        } else {
            $this->attributes['password_hash'] = $value;
        }
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->hasRole('admin');
        
    }


    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    public function getFilamentName(): string
    {
        // Make sure it always returns a string, never null
        if (!empty($this->full_name)) {
            return (string) $this->full_name;
        }

        if (!empty($this->name)) {
            return (string) $this->name;
        }

        if (!empty($this->email)) {
            return (string) $this->email;
        }

        return 'User';
    }

    // Relationships
    public function nationalIdCard()
    {
        return $this->hasOne(NationalIdCard::class, 'user_id');
    }

    public function licenses()
    {
        return $this->hasMany(License::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'actor_id');
    }
}
