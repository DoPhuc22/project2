<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Model
{
    use HasFactory;
    public $table = 'movie_genres';
    protected $fillable = ['movie_id', 'genre_id'];

    public function genre(){
        return $this -> belongsTo(Genre::class);
    }
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public $timestamps = false;

}
