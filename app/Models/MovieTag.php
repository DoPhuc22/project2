<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieTag extends Model
{
    protected $fillable = ['movie_id', 'tag_id'];
    public $timestamps = false;
    public function tag(){
        return $this -> belongsTo(Tag::class);
    }
    use HasFactory;
}
