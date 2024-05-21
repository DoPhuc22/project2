<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Requests\StoreCustomerRequest;
use App\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // ADMIN
    public function indexAdmin(Request $request)
    {
        $customers = Customer::latest();
        if (!empty($request->get('keyword'))){
            $customers = $customers->where('first_name', 'like', '%'.$request->get('keyword').'%' ) -> orWhere('last_name', 'like', '%'.$request->get('keyword').'%' );
        }
        $customers = $customers->paginate(10);
        return view('admin.customer_manager.index', ['customers' => $customers]);
    }


    public function create()
    {
        return view('admin.customer_manager.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => [
                'required',
                'min:6',
            ],
            //'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'status' => 'required'
        ]);
        if ($validator->passes()){
            $customer = new Customer();
            $customer->email  = $request->email;
            $customer->password = Hash::make($request->password);
            $customer->first_name  = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->phone_number  = $request->phone_number;
            $customer->address = $request->address;
            $customer->gender = $request->gender;
            $customer->status = $request->status;
            $customer->save();
            $request->session()->flash('success', 'Đã thêm khách hàng thành công 👍👍👍');
            return response()->json([
                'status' => true,
                'message' => 'Đã thêm khách hàng thành công 👍👍👍'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($customerId, Request $request)
    {
        $customer = Customer::find($customerId);
        if (empty($customer)){
            $request->session()->flash('error', 'Không tìm thấy khách hàng 😓');
            return redirect()->route('customerAdmin.index');
        }
        $data['customer'] = $customer;
        return view('admin.customer_manager.edit', $data);
    }

    public function update($customerId, Request $request)
    {
        $customer = Customer::find($customerId);
        if (empty($customer)){
            $request->session()->flash('error', 'Không tìm thấy khách hàng 😓');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Không tìm thấy khách hàng 😓'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => [
                'required',
                'min:6',
            ],
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'status' => 'required'
        ]);
        if ($validator->passes()){
            $customer->email  = $request->email;
            $customer->password = $request->password;
            $customer->first_name  = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->phone_number  = $request->phone_number;
            $customer->address = $request->address;
            $customer->gender = $request->gender;
            $customer->status = $request->status;
            $customer->save();
            $request->session()->flash('success', 'Đã cập nhật thông tin khách hàng thành công 👍👍👍');
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật thông tin khách hàng thành công 👍👍👍'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($customerId, Request $request)
    {
        $customer = Customer::find($customerId);
        if (empty($customer)){
            $request->session()->flash('error', 'Không tìm thấy khách hàng 😓');
            return response()->json([
                'status' => true,
                'message' => 'Không tìm thấy khách hàng 😓'
            ]);
        }

        $customer->delete();
        $request->session()->flash('success', 'Đã xóa khách hàng thành công 👍👍👍');
        return response()->json([
            'status' => true,
            'message' => 'Đã xóa khách hàng thành công 👍👍👍'
        ]);
    }
}
