<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    public $table = 'casts';
    protected $fillable = ['name', 'slug', 'image', 'status', 'created_at', 'updated_at'];
    use HasFactory;

    public function movie(){
        return $this -> belongsToMany(Movie::class, 'movie_casts');
    }
    public function movieCast(){
        return $this -> hasMany(MovieCast::class);
    }
}
