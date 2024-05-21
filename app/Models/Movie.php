<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';
    protected $fillable = ['title', 'director', 'description', 'is_featured', 'status', 'image', 'duration', 'release_date',
        'language', 'age_id', 'created_at', 'updated_at'];

    use HasFactory;

    public function age()
    {
        return $this->belongsTo(Age::class);
    }
}
