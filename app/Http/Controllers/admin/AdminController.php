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
                    return redirect()->route('admin.login')->with('error', 'You are not authorized to access admin panel.');
                }

            }else{
                return redirect()->route('admin.login')->with('error', 'Either Email/Password is incorrect');
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

    public function index2(Request $request)
    {
        $users = User::latest();
        if (!empty($request->get('keyword'))){
            $users = $users->where('name', 'like', '%'.$request->get('keyword').'%' );
        }
        $users = User::paginate(11);
        return view('admin.user_manager.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('admin.user_manager.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone_number' => 'required',
            'role' => 'required',
            'email' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()){
            $user = new User();
            $user->name = $request->name;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = $request->password;
            $user->save();
            // Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);
                $newImageName = $user->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/user/'.$newImageName;
                File::copy($sPath, $dPath);
                $user->image = $newImageName;
                $user->save();
            }

            $request->session()->flash('success', 'User added successfully');
            return response()->json([
                'status' => true,
                'message' => 'User added successfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($userID, Request $request)
    {
        $user = User::find($userID);
        if (empty($user)){
            $request->session()->flash('error', 'User not found');
            return redirect()->route('User.index');
        }
        $data['user'] = $user;
        return view('admin.user_manager.edit', $data);
    }

    public function update($userID, Request $request)
    {
        $user = User::find($userID);
        if (empty($user)){
            $request->session()->flash('error', 'User not found');

            return response()->json([
               'status' => false,
               'notFound' => true,
                'message' => 'User not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required',
            'role' => 'required',
            'email' => 'required',
        ]);
        if ($validator->passes()){
            $user->name = $request->name;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = $request->password;
            $user->save();

                // Save Image Here
                if (!empty($request->image_id)) {
                    $tempImage = TempImage::find($request->image_id);
                    $extArray = explode('.', $tempImage->name);
                    $ext = last($extArray);
                    $newImageName = $user->id.'.'.$ext;
                    $sPath = public_path().'/temp/'.$tempImage->name;
                    $dPath = public_path().'/uploads/user/'.$newImageName;
                    File::copy($sPath, $dPath);
                    $user->image = $newImageName;
                    $user->save();
                }

            $request->session()->flash('success', 'User updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'User updated successfully'
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
