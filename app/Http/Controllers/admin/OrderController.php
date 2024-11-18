<?php

namespace App\Http\Controllers\admin;

use App\Models\Age;
use App\Models\Cast;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieCast;
use App\Models\MovieGenre;
use App\Models\Seat;
use App\Models\Customer;
use App\Models\Screening;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ReservationType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SeatReserved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Reservation::latest();
        if (!empty($request->get('keyword'))){
            $orders = $orders->where('screening_id', 'like', '%'.$request->get('keyword').'%' );
        }
        $orders = $orders->paginate(18);
        return view('admin.order_manager.index', [
            'orders' => $orders,
        ]);
    }
}
