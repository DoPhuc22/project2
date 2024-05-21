<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatReserved extends Model
{
    public  $table = 'seat_reserved';
    public $timestamps = false;
    protected $fillable = ['seat_id', 'reservation_id', 'screening_id'];
    use HasFactory;
}
