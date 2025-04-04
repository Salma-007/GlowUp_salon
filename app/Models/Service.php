<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name', 'description', 'price', 'category_id','duration', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'employee_service');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
