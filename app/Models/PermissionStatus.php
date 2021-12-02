<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionStatus extends Model
{
    use HasFactory;

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_status_id', 'id');
    }
}
