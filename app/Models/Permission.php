<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    const APPROVED = 1;
    const PENDING = 2;
    const REJECTED = 3;

    
    const SAKIT = 1;
    const CUTI = 2;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(PermissionStatus::class, 'permission_status_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(PermissionType::class, 'permission_type_id', 'id');
    }

    public function scopeSakit($query)
    {
        return $query->where('permission_type_id', self::SAKIT);
    }

    public function scopeCuti($query)
    {
        return $query->where('permission_type_id', self::CUTI);
    }
}
