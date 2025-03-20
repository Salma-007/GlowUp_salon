<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name', 'description', 'price', 'category_id','duration'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
