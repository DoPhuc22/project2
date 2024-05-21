<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatType extends Model
{
    // Nếu create và store đơn giản mà ko được thì có khi do nó hiểu nhầm bảng?
    protected $table = 'seat_types';
    protected $fillable = ['name' ,'price'];
    public $timestamps = false;
    public function seat(){
        return $this ->hasMany(Seat::class);
    }
    use HasFactory;
}
