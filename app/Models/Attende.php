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
    const ABSENT = 3;

    const MASUK = 1;
    const KELUAR = 2;

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status_kehadiran()
    {
        return $this->belongsTo(AttendeStatus::class, 'attende_status_id', 'id');
    }

    public function type_kehadiran()
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

    public function scopeAbsen($query)
    {
        return $query->where('attende_status_id', self::ABSENT);
    }

    public function scopeMasuk($query)
    {
        return $query->where('attende_type_id', self::MASUK);
    }

    public function scopeKeluar($query)
    {
        return $query->where('attende_type_id', self::KELUAR);
    }
    
    public function format()
    {
        return [
            'user' => [
                'name' => $this->employee->name,
                'department' => $this->employee->departemen->name,
            ],
            'status_kehadiran' => $this->status_kehadiran->name,
            'jam_absen' => $this->attend_time,
        ];
    }

}
