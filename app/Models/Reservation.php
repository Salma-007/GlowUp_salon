<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'client_id',
        'employee_id',
        'service_id',
        'datetime',
        'status',
        'end_time',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'client_id'); 
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
