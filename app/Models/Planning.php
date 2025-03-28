<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $fillable = ['employee_id', 'start_time', 'end_time', 'event_name'];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
