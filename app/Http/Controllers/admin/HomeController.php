<?php

namespace App\Http\Controllers\admin;
use App\Models\User;
use App\Models\Movie;
use App\Models\TempImage;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        Auth::guard('admin')->user();

        $amount = DB::table('reservations')
            ->select(DB::raw('payment_date'), DB::raw('COUNT(*) AS reservations_count'))
            ->groupBy('payment_date')
            ->orderBy('payment_date')
            ->get();

        $firstChartData = [];
        foreach ($amount as $income) {
            $firstChartData[] = [
                'label' => $income->payment_date,
                'y' => $income->reservations_count,
            ];
        }

        $secondChartData = [];
        $seatTypeData = DB::table('reservations')
            ->select('seat_types.name', DB::raw('count(reservations.seat_id) as howMuch'), 'seat_types.price')
            ->join('seats', 'reservations.seat_id', '=', 'seats.id')
            ->join('seat_types', 'seats.type_id', '=', 'seat_types.id')
            ->groupBy('seat_types.name')
            ->get();

        foreach ($seatTypeData as $seatType) {
            $secondChartData[] = [
                'label' => $seatType->name . ' (Price: $' . $seatType->price . ')',
                'y' => $seatType->howMuch
            ];
        }

        // Delete temp images here
        $dayBeforeToday = Carbon::now()->subDays(1)->format('Y-m-d H:i:s');
        $tempImages = TempImage::where('created_at', '<=', $dayBeforeToday)->get();
        foreach ($tempImages as $tempImage){
            $path = public_path('/temp/'.$tempImage->name);

            //Delete main images
            if (File::exists($path)){
                File::delete($path);
            }
            TempImage::where('id', $tempImage->id)->delete();
        }

        $topFiveMostPopularMovies = Movie::select('movies.title',DB::raw('count(reservations.id) as reservation_count'))
            ->join('screenings','screenings.movie_id','=','movies.id')
            ->join('reservations','reservations.screening_id' ,'screenings.id')
            ->groupBy('movies.id')
            ->orderBy('reservation_count','desc')
            ->limit(5)
            ->get();

        $topFiveLeastPopularMovies = Movie::select('movies.title',DB::raw('count(reservations.id) as reservation_count'))
            ->join('screenings','screenings.movie_id','=','movies.id')
            ->join('reservations','reservations.screening_id' ,'screenings.id')
            ->groupBy('movies.id')
            ->orderBy('reservation_count','asc')
            ->limit(5)
            ->get();

        // $totalIncomes = Reservation::select(DB::raw('SUM(payment_amount) as total_income'))->get();

        // $todayIncomes = Reservation::select(DB::raw('DATE(payment_date) as payment_date'),DB::raw('SUM(payment_amount) AS daily_income'))
        // ->groupBy(DB::raw('DATE(payment_date)'))
        // ->orderBy('payment_date')
        // ->limit(1)
        // ->get();


        $popularBookingHours = Reservation::select(DB::raw('HOUR(screening_start) as booking_hour'), DB::raw('COUNT(*) AS booking_count'))
            ->join('screenings', 'reservations.screening_id', '=', 'screenings.id')
            ->groupBy('booking_hour')
            ->orderBy('booking_count', 'desc')
            ->get();
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');
        $lastSevenDays = Carbon::now()->subDays(7)->format('Y-m-d');

        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $revenueTodays = Reservation::where('payment_date', '=', $currentDate)
            -> join('seats', 'reservations.seat_id', '=', 'seats.id')
            -> join('seat_types', 'seats.type_id', '=', 'seat_types.id')
            -> select(DB::raw('sum(price) as revenueToday'))->get();
//    dd($revenueTodays);
        $revenueLastSevenDays = Reservation::where('payment_date', '>=', $lastSevenDays)
            -> join('seats', 'reservations.seat_id', '=', 'seats.id')
            -> join('seat_types', 'seats.type_id', '=', 'seat_types.id')
            -> select(DB::raw('sum(price) as revenueLastSevenDays'))->get();

        $revenueThisMonth = Reservation::where('payment_date', '>=', $startOfMonth)
            -> where('payment_date', '<=', $currentDate)
            -> join('seats', 'reservations.seat_id', '=', 'seats.id')
            -> join('seat_types', 'seats.type_id', '=', 'seat_types.id')
            -> select(DB::raw('sum(price) as revenueThisMonth'))->get();

        $revenueLastMonth = Reservation::where('payment_date', '>=', $lastMonthStartDate)
            -> where('payment_date', '<=', $lastMonthEndDate)
            -> join('seats', 'reservations.seat_id', '=', 'seats.id')
            -> join('seat_types', 'seats.type_id', '=', 'seat_types.id')
            -> select(DB::raw('sum(price) as revenueLastMonth'))->get();
        // dd($revenueLastMonth);
        return view('admin.dashboard', [
            'firstChartData' => $firstChartData,
            'secondChartData' => $secondChartData, // Pass the processed data for charts
            'topFiveMostPopularMovies'=> $topFiveMostPopularMovies,
            'topFiveLeastPopularMovies' => $topFiveLeastPopularMovies,
            'popularBookingHours' => $popularBookingHours,
            'revenueThisMonth' => $revenueThisMonth,
            'revenueLastMonth' => $revenueLastMonth,
            'revenueTodays' => $revenueTodays,
            'revenueLastSevenDays' => $revenueLastSevenDays
        ]);
        //echo 'welcome'.$admin->name.' <a href="'.route('admin.logout').'">Logout</a>';
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
