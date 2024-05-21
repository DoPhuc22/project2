<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieCast extends Model
{
    public $table = 'movie_casts';
    protected $fillable = ['movie_id', 'cast_id'];
    public function cast(){
        return $this -> belongsTo(Cast::class);
    }
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public $timestamps = false;
    use HasFactory;
}
