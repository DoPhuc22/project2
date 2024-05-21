<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodReserved extends Model
{
    protected $fillable = [
        'food_id',
        'reservation_id'
    ];
    public $timestamps = false;
    protected $table = 'food_reserved';
    public function foods()
    {
        return $this->belongsToMany(Food::class, 'food_reserved');
    }
    use HasFactory;
}
