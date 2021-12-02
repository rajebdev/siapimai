<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Gender;
use App\Models\Department;
use App\Models\Permission;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender_id',
        'department_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function departemen()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function permission()
    {
        return $this->hasMany(Permission::class, 'user_id', 'id');
    }

    public function scopePria($query)
    {
        return $query->where('gender_id', 1);
    }

    public function scopeWanita($query)
    {
        return $query->where('gender_id', 2);
    }

    public function format($date)
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'department' => $this->departemen->name,
            'presensi' =>
            $this->presensi()->with('status_kehadiran')->whereDate('created_at', $date)->get()->map(function ($presensi) use ($date) {
                $status = $presensi->status_kehadiran->name;
                if ($status === 'Terlambat') {
                    $status = $presensi->status_kehadiran->name;
                    $status .= 'Hitung Keterlambatan';
                }
                return [
                    'status' => $status,
                    'attend_time' => $presensi->attend_time == null ? "-" : Carbon::parse($presensi->attend_time)->format('H:i')
                ];
            })

        ];
    }
}
