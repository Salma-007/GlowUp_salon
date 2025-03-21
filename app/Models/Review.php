<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'comment',
        'rating',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
