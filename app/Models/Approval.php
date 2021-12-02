<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    const APPROVED = 1;
    const PENDING = 2;
    const REJECTED = 3;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(ApprovalStatus::class, 'approval_status_id', 'id');
    }
}
