<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'number_of_row',
        'number_of_col',
        'status',
        'auditorium_id',
        'type_id',
    ];    public $timestamps = false;
    public function auditorium(){
        return $this -> belongsTo(auditorium::class);
    }
    public function seatType()
    {
        return $this->belongsTo(SeatType::class);
    }

//    public function isBooked(Movie $movie, Reservation $reservation, Screening $showtime): bool
//    {
//        return DB::table('seat_reserved')
//            ->join('screenings', 'seat_reserved.screening_id', '=', 'id')
//            ->join('reservations', 'seat_reserved.reservation_id', '=', 'id')
//            ->where('date_showtime.showtime_id', $showtime->id)
//            ->where('seat_reserved.seat_id', $this->id)
//            ->where('bookings.movie_id', $movie->id)
//            ->exists();
//    }
    use HasFactory;
}
