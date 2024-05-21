<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class CastController extends Controller
{
    public function index(Request $request)
    {
        $casts = Cast::latest();
        if (!empty($request->get('keyword'))){
            $casts = $casts->where('name', 'like', '%'.$request->get('keyword').'%' );
        }
        $casts = $casts->paginate(6);
        return view('admin.cast_manager.index', [
            'casts' => $casts,
        ]);
    }

    public function create()
    {
        return view('admin.cast_manager.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:casts'
        ]);
        if ($validator->passes()){
            $cast = new Cast();
            $cast->name = $request->name;
            $cast->slug = $request->slug;
            $cast->status = $request->status;
            $cast->save();

//             Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $cast->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/cast/'.$newImageName;
                File::copy($sPath, $dPath);

                // Generate Image Thumbnail
//                $dPath = public_path().'/uploads/cast/thumb/'.$newImageName;
//                $img = Image::make($sPath);
//                $img->resize(450, 600);
//                $img->save($dPath);

                $cast->image = $newImageName;
                $cast->save();
            }


            $request->session()->flash('success', 'Đã thêm diễn viên thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã thêm diễn viên thành công'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($castId, Request $request)
    {
        $cast = Cast::find($castId);
        if (empty($cast)){
            $request->session()->flash('error', 'Không tìm thấy diễn viên');
            return redirect()->route('cast.index');
        }
        $data['cast'] = $cast;
        return view('admin.cast_manager.edit', $data);
    }

    public function update($castId, Request $request)
    {
        $cast = Cast::find($castId);
        if (empty($cast)){
            $request->session()->flash('error', 'Không tìm thấy diễn viên');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Không tìm thấy diễn viên'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:casts,slug,'.$cast->id.',id',
        ]);
        if ($validator->passes()){
            $cast->name = $request->name;
            $cast->slug = $request->slug;
            $cast->status = $request->status;
            $cast->save();
            $oldImage = $cast->image;

            //             Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $cast->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/cast/'.$newImageName;
                File::copy($sPath, $dPath);

                // Generate Image Thumbnail
//                $dPath = public_path().'/uploads/cast/thumb/'.$newImageName;
//                $img = Image::make($sPath);
//                $img->resize(450, 600);
//                $img->save($dPath);

                $cast->image = $newImageName;
                $cast->save();

                // DELETE old image here
                File::delete(public_path().'/temp/'.$oldImage);
                File::delete(public_path().'/uploads/cast/'.$oldImage);
            }

            $request->session()->flash('success', 'Đã cập nhật thông tin diễn viên thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật thông tin diễn viên thành công'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($castId, Request $request)
    {
        $cast = Cast::find($castId);
        if (empty($cast)){
            $request->session()->flash('error', 'Không tìm thấy diễn viên');
            return response()->json([
                'status' => true,
                'message' => 'Không tìm thấy diễn viên'
            ]);
        }

        File::delete(public_path().'/temp/'.$cast->image);
        File::delete(public_path().'/uploads/cast/'.$cast->image);
        $cast->delete();
        $request->session()->flash('success', 'Đã xóa diễn viên thành công');
        return response()->json([
            'status' => true,
            'message' => 'Đã xóa diễn viên thành công'
        ]);
    }
}
