<?php

namespace App\Http\Controllers\admin;

use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auditorium;
use Illuminate\Support\Facades\Validator;

class ScreeningController extends Controller
{
    public function index(Request $request){
        $screenings = Screening::latest();
        if (!empty($request->get('keyword'))){
            $screenings = $screenings->where('name', 'like', '%'.$request->get('keyword').'%' ) -> movie -> auditorium;
        }
        $screenings = $screenings -> paginate(10);
        return view('admin.screening_manager.index', ['screenings' => $screenings]);
    }
    public function create()
    {
        $screenings = Screening::latest();
        $movies = Movie::all();
        $auditorium = Auditorium::all();
        return view('admin.screening_manager.create',['screenings' => $screenings , 'movies' => $movies, 'auditoriums' => $auditorium]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
           'movie_id' => 'required',
           'auditorium_id' => 'required',
           'screening_start' => 'required',
           'screening_end' => 'required|after:screening_start'
        ]);
        if ($validator->passes()){
            $screening = new Screening();
            $screening-> movie_id = $request->movie_id;
            $screening-> auditorium_id = $request->auditorium_id;
            $screening-> screening_start = $request->screening_start;
            $screening-> screening_end = $request->screening_end;
            $screening->save();
            $request->session()->flash('success', 'Đã thêm đợt chiếu thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã thêm đợt chiếu thành công'
            ]);

        }else{
            return response()->json([
               'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit(Screening $screening){
        $movies = Movie::all();
        $auditorium = Auditorium::all();
        return view('admin.screening_manager.edit',['screening' => $screening , 'movies' => $movies, 'auditoriums' => $auditorium]);
    }
    public function update($screeningId, Request $request)
    {
        $screening = Screening::find($screeningId);
        if (empty($screening)){
            $request->session()->flash('error', 'Không tìm thấy đợt chiếu nào');

            return response()->json([
               'status' => false,
               'notFound' => true,
               'message' => 'Không tìm thấy đợt chiếu nào'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'movie_id' => 'required',
            'auditorium_id' => 'required',
            'screening_start' => 'required',
            'screening_end' => 'required|after:screening_start'
         ]);
        if ($validator->passes()){
            $screening-> movie_id = $request->movie_id;
            $screening-> auditorium_id = $request->auditorium_id;
            $screening-> screening_start = $request->screening_start;
            $screening-> screening_end = $request->screening_end;
            $screening->save();

            $request->session()->flash('success', 'Đã cập nhật đợt chiếu thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật đợt chiếu thành công'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($screeningId, Request $request)
    {
        $screening = Screening::find($screeningId);
        if (empty($screening)) {
            $request->session()->flash('error', 'Không tìm thấy đợt chiếu nào');
            return response()->json([
                'status' => true,
                'message' => 'Không tìm thấy đợt chiếu nào'
            ]);
        }

        $screening->delete();
        $request->session()->flash('success', 'Đã xóa đợt chiếu thành công');
        return response()->json([
            'status' => true,
            'message' => 'Đã xóa đợt chiếu thành công'
        ]);
    }
}
