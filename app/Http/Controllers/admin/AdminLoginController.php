<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminLoginController extends Controller
{
    //
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()){
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember')))
            {
                $admin = Auth::guard('admin')->user();

                if ($admin->role == 1){
                    return redirect()->route('admin.dashboard');
                }elseif ($admin->role == 2){
                    return redirect()->route('admin.dashboard');
                }
                else{
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error', 'Bạn không được phép truy cập trang quản trị.');
                }
            }else{
                return redirect()->route('admin.login')->with('error', 'Email hoặc mật khẩu không đúng');
            }
        }else{
            return redirect()->route('admin.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function showChangePasswordForm()
    {
        return view('admin.changePassword');
    }

    public function processChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        $id = Auth::guard('admin')->user()->id;
        $admin = User::where('id', $id)->first();

        if ($validator->passes()){
            if (!Hash::check($request->old_password, $admin->password)){
                session()->flash('error', 'Mật khẩu cũ của bạn không đúng, vui lòng thử lại.');
                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id', $id)->update([
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
}
