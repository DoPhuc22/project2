<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'status',
    ];
    public $timestamps = false;
    protected $table = 'foods';
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'food_reserved');
    }
    use HasFactory;
}
