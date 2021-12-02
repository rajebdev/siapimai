<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendeType extends Model
{
    use HasFactory;

    public function kehadiran()
    {
        return $this->hasMany(Attende::class, 'attende_type_id', 'id');
    }
}
