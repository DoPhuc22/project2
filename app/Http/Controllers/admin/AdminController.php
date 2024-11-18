<?php

namespace App\Http\Controllers\admin;
use App\Models\User;
use App\Models\TempImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
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
                }else{
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

    public function profile()
    {
        return view('admin.profile.profile');
    }

    public function update(Request $request)
    {
        $userId = Auth::guard('admin')->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,'.$userId.',id',
        ]);
        if ($validator -> passes()){
            $user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->save();
            $oldImage = $user->image;
            //             Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $user->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/user/'.$newImageName;
                File::copy($sPath, $dPath);

                // Generate Image Thumbnail
//                $dPath = public_path().'/uploads/cast/thumb/'.$newImageName;
//                $img = Image::make($sPath);
//                $img->resize(450, 600);
//                $img->save($dPath);

                $user->image = $newImageName;
                $user->save();

                // DELETE old image here
                File::delete(public_path().'/temp/'.$oldImage);
                File::delete(public_path().'/uploads/user/'.$oldImage);
            }
            $request->session()->flash('success', 'Hồ sơ được cập nhật thành công');
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

    public function destroy($userID, Request $request)
    {
        $user = User::find($userID);
        if (empty($user)){
            $request->session()->flash('error', 'User not found');
            return response()->json([
                'status' => true,
                'message' => 'User not found'
            ]);
        }

        $user->delete();
        $request->session()->flash('success', 'User deleted successfully');
        return response()->json([
           'status' => true,
           'message' => 'User deleted successfully'
        ]);
    }
}
