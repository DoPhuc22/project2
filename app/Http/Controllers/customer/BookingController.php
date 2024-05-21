<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Auditorium;
use App\Models\Customer;
use App\Models\Movie;
use App\Models\Reservation;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\SeatReserved;
use App\Models\SeatType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{

    public function choosingScreening($id, Request $request){
        $movie_id = Movie::find($id)->id;
        if (empty($movie_id)){
            $request->session()->flash('error', 'Movie not found');
            return redirect()->route('movie');
        }
        $screening = Screening::all()->where('movie_id','=',$request->movie_id);
        return view('customer.book_ticket.choosingScreening',[
            'screening' => $screening,
            'movie_id' => $movie_id,
        ]);
    }

    public function postScreening(Request $request){
        $movie = $request -> movie_id;
        $screening = $request -> screening_id;
        $auditorium = $request -> auditorium_id;
        return redirect()->route('choosingSeat', [
                'movie_id' => $movie,
                'screening_id' => $screening,
                'auditorium_id' => $auditorium
            ]
        );
    }

    public function choosingSeat($id, Request $request){
        $movieId = Movie::find($id);
        if (empty($movieId)){
            $request->session()->flash('error', 'Movie not found');
            return redirect()->route('movie');
        }
        $screening = Screening::all()->where('movie_id','=',$request->movie_id);
        $screeningId = $request->screening_id;
        $auditorium = $request->auditorium_id;
        $reservedSeats = SeatReserved::where('screening_id', $screeningId)->get();
        $seats  = Seat::where('auditorium_id','=', $auditorium )->orderBy('number_of_col','asc')->orderBy('id','asc')->get();
        return view('customer.book_ticket.choosingSeat',[
            'movie' => $movieId,
            'movie_id' => $request->movie_id,
            'seats' => $seats,
            'auditorium' => $auditorium,
            'screening' => $screening,
            'screeningId' => $screeningId,
            'reservedSeats'=> $reservedSeats,
        ]);
    }

    public function bookingStore(Request $request){
        $id = Auth::guard('customer')->user()->id;
        $customer = Customer::find($id);
        // $movie = Movie::find($request->movie_id);
        $validator = Validator::make($request->all(), [
            'movie' => 'required',
            'screening_id' => 'required',
            'customer_id' => 'required',
            'seat_id' => 'required'
        ]);
        // if($validator->passes()){
        $contact = $customer -> phone_number;
        $screening = $request->screening_id;
        $totalSeats = [];
        foreach($request->seat_id as $seat){
            $totalSeats[] = $seat;
        }
        $array = [];
        $array = Arr::add($array, 'seat_id', $request->seat_id);
        $array = Arr::add($array, 'movie_id', $request->movie_id);
        return redirect(route('customer.checkout',[
            'screening' => $screening,
            'seat_id' => $request->seat_id,
            'auditorium' => $request->auditorium_id,
            'movie_id' => $request->movie_id,
            'totalSeats' => $totalSeats,
        ]));
    }

    public function checkout($id, Request $request)
    {
        // Cần lấy screening movie seat auditorium
        // và cái quan trọng nhất là lấy tổng tiền của tổng ghế
        $movieId = Movie::find($id);
        if (empty($movieId)){
            $request->session()->flash('error', 'Movie not found');
            return redirect()->route('movie');
        }
        $totalMoney = 0;
        $totalSeats = $request->totalSeats;
        foreach($totalSeats as $totalSeat){
            $money = Seat::select(DB::raw('sum(seat_types.price) as total_price'))
                ->join('seat_types', 'seat_types.id', '=', 'seats.type_id')
                ->where('seats.id', '=',$totalSeat)
                ->first();
            $totalMoney += $money->total_price;
        }
        if (Auth::guard('customer')->check() === false){
            if (!session()->has('url.intended')){
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('customer.login');
        }
        session()->forget('url.intended');

        $seats = DB::table('seats')->whereIn('id', $totalSeats)->get();
        $movie = Movie::all()->where('id','=',$request->movie);
        $screening = Screening::all()->where('id','=',$request->screening);
        $auditorium = Auditorium::all()->where('id','=',$request->auditorium);
        $whatTypesOfSeats = $seatTypes = SeatType::select(
            DB::raw('count(seats.id) as id'),
            'seat_types.name',
            DB::raw('sum(seat_types.price) as totalPrice') // Use price from seats
        )
            ->join('seats', 'seats.type_id', '=', 'seat_types.id')
            ->whereIn('seats.id', $totalSeats)
            ->groupBy('seat_types.name')
            ->get();
        return view('customer.book_ticket.checkout',[
            'movie' => $movie,
            'totalMoney' => $totalMoney,
            'screening' => $screening,
            'auditorium' => $auditorium,
            'seats'=> $seats,
            'seatTypes' => $whatTypesOfSeats,
        ]);
    }

    public function vnpay_payment(Request $request){

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/test";
        $vnp_TmnCode = "6IJUBOIH";//Mã website tại VNPAY
        $vnp_HashSecret = "NTWDAASDAOTUICDMDVBVJMAFTPTXNACU"; //Chuỗi bí mật
        $customer = Auth::guard('customer')->user()->id;
        $contact = Auth::guard('customer')->user()->phone_number;
        $validator = Validator::make($request->all(), [
            'seat' => 'required',
            'movie' => 'required',
            'screening' => 'required',
            'totalMoney' => 'required'
        ]);
        $bookingData = [
            'customer' => $customer,
            'contact' => $contact,
            'movie' => $request->movie,
            'screening' => $request->screening,
            'seats' => $request->seat,
        ];
        if($validator->passes()){
            $vnp_TxnRef = random_int(1,1000000000);
            $vnp_OrderInfo = 'Thanh toán hóa đơn';
            $vnp_OrderType = 'Paradise Cinema';
            $vnp_Amount = $request->totalMoney * 100000;
            $vnp_Locale = 'VN';
            $vnp_BankCode = "NCB";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,

            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }


            session()->put('bookingData',$bookingData);
            session()->save();

            $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
            // vui lòng tham khảo thêm tại code demo

        }
    }

    public function finishCheckOut(){

        // dd(session()->get('bookingData'));
        $data = session('bookingData');
        // $movie = $data['movie'];
        // $screening = $data['screening'];
        // $customer = $data
        // dd($movie);
        foreach($data['seats'] as $seat){
            $reservation = Reservation::create([
                'movie' => $data['movie'],
                'screening_id' => $data['screening'],
                'customer_id' => $data['customer'],
                'status' => 1,
                'date' => now(),
                'seat_id' => $seat,
                'reservation_contact' => $data['contact'],
            ]);
            SeatReserved::create([
                'seat_id' => $seat,
                'reservation_id' => $reservation->id,
                'screening_id' => $data['screening'],
            ]);
        }

        return view('customer.home');
    }
}
