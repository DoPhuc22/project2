<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $genres = Genre::latest();
        if (!empty($request->get('keyword'))){
            $genres = $genres->where('name', 'like', '%'.$request->get('keyword').'%' );
        }
        $genres = $genres->paginate(14);
        return view('admin.genre_manager.index', [
            'genres' => $genres,
        ]);
    }

    public function create()
    {
        return view('admin.genre_manager.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required',
        ]);
        if ($validator->passes()){
            $genre = new Genre();
            $genre->name = $request->name;
            $genre->description = $request->description;
            $genre->status = $request->status;
            $genre->save();

            $request->session()->flash('success', 'Đã thêm thể loại thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã thêm thể loại thành công'
            ]);

        }else{
            return response()->json([
               'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($genreId, Request $request)
    {
        $genre = Genre::find($genreId);
        if (empty($genre)){
            $request->session()->flash('error', 'Không tìm thấy thể loại');
            return redirect()->route('genre.index');
        }
        $data['genre'] = $genre;
        return view('admin.genre_manager.edit', $data);
    }

    public function update($genreId, Request $request)
    {
        $genre = Genre::find($genreId);
        if (empty($genre)){
            $request->session()->flash('error', 'Không tìm thấy thể loại');

            return response()->json([
               'status' => false,
               'notFound' => true,
                'message' => 'Không tìm thấy thể loại'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
//            'description' => 'required',
        ]);
        if ($validator->passes()){
            $genre->name = $request->name;
            $genre->description = $request->description;
            $genre->status = $request->status;
            $genre->save();

            $request->session()->flash('success', 'Đã cập nhật thông tin thể loại thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật thông tin thể loại thành công'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($genreId, Request $request)
    {
        $genre = Genre::find($genreId);
        if (empty($genre)){
            $request->session()->flash('error', 'Không tìm thấy thể loại');
            return response()->json([
                'status' => true,
                'message' => 'Không tìm thấy thể loại'
            ]);
        }

        $genre->delete();
        $request->session()->flash('success', 'Đã xóa thể loại thành công');
        return response()->json([
           'status' => true,
           'message' => 'Đã xóa thể loại thành công'
        ]);
    }
}
