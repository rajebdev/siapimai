<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attende extends Model
{
    use HasFactory;

    protected $guarded = [];

    const ON_TIME = 1;
    const LATE = 2;
    const STATUS_NOT_VALID = 3;

    const MASUK = 1;
    const KELUAR = 2;
    const TYPE_NOT_VALID = 3;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(AttendeStatus::class, 'attende_status_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(AttendeType::class, 'attende_type_id', 'id');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeHadir($query)
    {
        return $query->where('attende_status_id', self::ON_TIME);
    }

    public function scopeTerlambat($query)
    {
        return $query->where('attende_status_id', self::LATE);
    }

    public function scopeStatusNotValid($query)
    {
        return $query->where('attende_status_id', self::STATUS_NOT_VALID);
    }

    public function scopeMasuk($query)
    {
        return $query->where('attende_type_id', self::MASUK);
    }

    public function scopeKeluar($query)
    {
        return $query->where('attende_type_id', self::KELUAR);
    }

    public function scopeTypeNotValid($query)
    {
        return $query->where('attende_type_id', self::TYPE_NOT_VALID);
    }
    
    public function format()
    {
        return [
            'user' => [
                'name' => $this->user->name,
                'department' => $this->user->departement->name,
            ],
            'status_kehadiran' => $this->status->name,
            'jam_absen' => $this->attend_time,
        ];
    }

}
