<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordEmail;
use App\Models\Customer;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieGenre;
use App\Models\Order;
use App\Models\WishList;
use App\Requests\StoreCustomerRequest;
use App\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Laravel\Prompts\password;

class CustomerController extends Controller
{
    public function register()
    {
        return view('customer.register');
    }

    public function registerProcess(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:5|confirmed',
//            'birthday' => 'required',
            'gender' => 'required',
            'status' => 'required'
        ]);
        if ($validator->passes()) {
            $customer = new Customer;
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->email = $request->email;
            $customer->password = Hash::make($request->password);
            $customer->phone_number = $request->phone_number;
            $customer->address = $request->address;
//            $customer->birthday = $request->birthday;
            $customer->gender = $request->gender;
            $customer->status = 1;
            $customer->save();

            session()->flash('success', 'You have been registered successfully.');

            return response()->json([
                'status' => true,
            ]);
        }else {
            return response()->json([
               'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function login()
    {
        return view('customer.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()) {
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember')))
            {
                $customer = Auth::guard('customer')->user();
//                Auth::guard('customer')->login($customer);
//                session(['customer' => $customer]);

                if ($customer->status == 1){
                    if (session()->has('url.intended'))
                    {
                        return redirect(session()->get('url.intended'));
                    }
                    return redirect()->route('profile');
                }
                else{
                    Auth::guard('customer')->logout();
                    return redirect()->route('customer.login')->with('error', 'Your account has been locked.');
                }
            }else{
//                session()->flash('error', 'Either email/password is incorrect.');
                return redirect()->route('customer.login')
                    ->withInput($request->only('email'))
                    ->with('error', 'Either email/password is incorrect.');
            }

        }else {
            return redirect()->route('customer.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

//        $account = $request->only(['email', 'password']);
//        $check = Auth::guard('customer')->attempt($account);
//
//        if ($check) {
//            //Lấy thông tin của customer đang login
//            $customer = Auth::guard('customer')->user();
//            //Cho login
//            Auth::guard('customer')->login($customer);
//            //Ném thông tin customer đăng nhập lên session
//            session(['customer' => $customer]);
//            return Redirect::route('profile');
//        } else {
//            //cho quay về trang login
//            return Redirect::back();
//        }
    }

    public function profile()
    {
        $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        return view('customer.profiles.profile', [
            'customer' => $customer
        ]);
    }

    public function update_profile(Request $request)
    {
        $customerId = Auth::guard('customer')->user()->id;
        $validator = Validator::make($request->all(), [
           'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:customers,email,'.$customerId.',id',
            'gender' => 'required',
        ]);
        if ($validator -> passes()){
            $customer = Customer::find($customerId);
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->email = $request->email;
            $customer->gender = $request->gender;
            $customer->phone_number = $request->phone_number;
            $customer->address = $request->address;
            $customer->save();

            session()->flash('success', 'Hồ sơ được cập nhật thành công');
            return response()->json([
                'status' => true,
                'message' => 'Hồ sơ được cập nhật thành công'
            ]);
        }else{
            return response()->json([
               'status' => false,
               'errors' => $validator->errors()
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        session()->forget('customer');
        return redirect()->route('customer.login')
            ->with('success', 'Bạn đã đăng xuất thành công!');
    }

    public function wishlist(Movie $movie)
    {
        $genres = Genre::all();
        $movieGenres = MovieGenre::all();
        $id = Auth::guard('customer')->user()->id;
        $wishlists = WishList::where('customer_id', $id)->with('movie')->get();
        $data = [];
        $data['movieGenres'] = $movieGenres;
        $data['movie'] = $movie;
        $data['genres'] = $genres;
        $data['customer'] = Customer::find($id);
        $data['wishlists'] = $wishlists;
        return view('customer.profiles.wishlist', $data);
    }

    public function removeMovieFromWishList(Request $request)
    {
        $wishlist = WishList::where('customer_id', Auth::guard('customer')->user()->id)->where('movie_id', $request->id)->first();
        if ($wishlist == null){
            session()->flash('error', 'Phim đã bị xóa rồi.');
            return response()->json([
                'status' => true,
            ]);
        }else{
            WishList::where('customer_id', Auth::guard('customer')->user()->id)->where('movie_id', $request->id)->delete();
            session()->flash('success', 'Đã xóa phim khỏi mục phim yêu thích thành công.');
            return response()->json([
               'status' => true,
            ]);
        }
    }

    public function showChangePassword()
    {
        $customer = Customer::where('id', Auth::guard('customer')->user()->id)->first();
        return view('customer.profiles.changePassword', [
            'customer' => $customer
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);
        if ($validator->passes()){
            $customer = Customer::select('id', 'password')->where('id', Auth::guard('customer')->user()->id)->first();

            if (!Hash::check($request->old_password, $customer->password)){
                session()->flash('error', 'Mật khẩu cũ của bạn không chính xác, vui lòng thử lại.');
                return response()->json([
                    'status' => true,
                ]);
            }

            Customer::where('id', $customer->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            session()->flash('success', 'Bạn đã đổi mật khẩu thành công.');
            return response()->json([
                'status' => true,
            ]);
        }else{
            return response()->json([
               'status' => false,
               'errors' => $validator->errors()
            ]);
        }
    }
    public function forgotPassword()
    {
        return view('customer.forgot-password');
    }

    public function processForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email'
        ]);

        if ($validator->fails()){
            return \redirect()->route('customer.forgotPassword')->withInput()->withErrors($validator);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        //send Email here
        $customer = Customer::where('email', $request->email)->first();

        $formData = [
            'token' => $token,
            'customer'=> $customer,
            'mailSubject' => 'Bạn đã yêu cầu đặt lại mật khẩu của mình'
        ];
        Mail::to($request->email)->send(new ResetPasswordEmail($formData));

        return \redirect()->route('customer.forgotPassword')->with('success', 'Vui lòng kiểm tra hộp thư đến của bạn để đặt lại mật khẩu.');
    }

    public function resetPassword($token)
    {
        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenExist == null){
            return \redirect()->route('forgotPassword')->with('error', 'Invalid request');
        }
        return view('customer.reset-password', [
            'token' => $token
        ]);
    }

    public function processResetPassword(Request $request)
    {
        $token = $request->token;
        $tokenObj = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenObj == null){
            return \redirect()->route('forgotPassword')->with('error', 'Invalid request');
        }

        $customer = Customer::where('email', $tokenObj->email)->first();
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->fails()){
            return \redirect()->route('customer.resetPassword', $token)->withErrors($validator);
        }

        Customer::where('id', $customer->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        DB::table('password_reset_tokens')->where('email', $customer->email)->delete();
        return \redirect()->route('customer.login')->with('success', 'Bạn đã cập nhật mật khẩu thành công');
    }
//
//    public function updateProfile(UpdateCustomerRequest $request)
//    {
//        //Lấy dữ liệu trong form và update lên db
//        $array = [];
//        $array = Arr::add($array, 'first_name', $request->first_name);
//        $array = Arr::add($array, 'last_name', $request->last_name);
//        $array = Arr::add($array, 'email', $request->email);
//        $array = Arr::add($array, 'phone_number', $request->phone_number);
//        $array = Arr::add($array, 'address', $request->address);
//
//        //id cua customer dang dang nhap
//        $id = Auth::guard('customer')->user()->id;
//        //lay ban ghi
//        $customer = Customer::find($id);
//        $customer->update($array);
//        //Quay về danh sách
//        return Redirect::route('profile');
//    }
//
//    public function showOrderHistory()
//    {
//        //id cua customer dang dang nhap
//        $id = Auth::guard('customer')->user()->id;
//        //lay ban ghi
//        $customer = Customer::find($id);
//        $orders = Order::where('customer_id', $id)->paginate(2);
//
//        return view('customer.profiles.orderHistory', [
//            'customer' => $customer,
//            'orders' => $orders,
//        ]);
//    }
//
//    public function orderDetail(Order $order)
//    {
//        //id cua customer dang dang nhap
//        $id = Auth::guard('customer')->user()->id;
//        //lay ban ghi
//        $customer = Customer::find($id);
//        $orderId = $order->id;
//        $orderDetails = DB::table('orders_details')
//            ->where('order_id', '=', $orderId)
//            ->join('products', 'orders_details.product_id', '=', 'products.id')
//            ->get();
//
//        $orderAmount = 0;
//        $orderItems = 0;
//        foreach ($orderDetails as $detail) {
//            $orderItems += $detail->sold_quantity;
//            $orderAmount += $detail->sold_price * $detail->sold_quantity;
//        }
//        $orderTotal = $orderAmount + 10;
//
//        return view('customers.profiles.orderDetail', [
//            'order' => $order,
//            'order_details' => $orderDetails,
//            'order_item' => $orderItems,
//            'order_amount' => $orderAmount,
//            'order_total' => $orderTotal,
//            'customer' => $customer,
//        ]);
//    }
//
//    public function editPassword()
//    {
//        //id cua customer dang dang nhap
//        $id = Auth::guard('customer')->user()->id;
//        //lay ban ghi
//        $customer = Customer::find($id);
//        return view('customer.profiles.changePassword', [
//            'customer' => $customer
//        ]);
//    }
//
//    public function updatePassword(UpdateCustomerRequest $request)
//    {
//        $newPwd = Hash::make($request->new_pwd);
//        $newPwd2 = $request->new_pwd2;
//
//        $array = [];
//        $array = Arr::add($array, 'password', $newPwd);
//        //id cua customer dang dang nhap
//        $id = Auth::guard('customer')->user()->id;
//        //lay ban ghi
//        $customer = Customer::find($id);
//        $customer->update($array);
//
//        return Redirect::route('profile')->with('success', 'Your password has been changed successfully');
//    }
}
