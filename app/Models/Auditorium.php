<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditorium extends Model
{
    public $table = 'auditoriums';
    protected $fillable = ['name', 'capacity'];
    use HasFactory;
}
