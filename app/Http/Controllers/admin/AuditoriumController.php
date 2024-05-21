<?php

namespace App\Http\Controllers\admin;

use App\Models\Seat;
use App\Models\Auditorium;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuditoriumController extends Controller
{
    public function index(){
        $auditoriums = Auditorium::all();
        return view('admin.auditorium_manager.index',['auditoriums' => $auditoriums]);
    }
    public function create(){
        return view('admin.auditorium_manager.create');
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'capacity' => 'required'
        ]);
        if ($validator->passes()){
            $auditoriums = new Auditorium();
            $auditoriums -> name = $request -> name;
            $auditoriums -> capacity = $request -> capacity;
            $auditoriums->save();
            $request->session()->flash('success', 'Đã thêm phòng chiếu thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã thêm phòng chiếu thành công'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function show(){}



    public function edit($auditoriumId, Request $request){
        $auditorium = Auditorium::find($auditoriumId);
        if (empty($auditorium)){
            $request->session()->flash('error', 'Không tìm thấy phòng chiếu');
            return redirect()->route('auditorium.index');
        }
        $data['auditorium'] = $auditorium;
        return view('admin.auditorium_manager.edit', $data);
    }

    public function update($auditoriumId, Request $request){
        $auditorium = Auditorium::find($auditoriumId);
        if (empty($auditorium)){
            $request->session()->flash('error', 'Không tìm thấy phòng chiếu');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Không tìm thấy phòng chiếu'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'capacity' => 'required',
        ]);
        if ($validator->passes()){
            $auditorium->name = $request->name;
            $auditorium->capacity = $request->capacity;
            $auditorium->save();

            $request->session()->flash('success', 'Đã cập nhật thông tin phòng chiếu thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật thông tin phòng chiếu thành công'
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
        $auditoriums = Auditorium::find($genreId);
        if (empty($auditoriums)){
            $request->session()->flash('error', 'Không tìm thấy phòng chiếu');
            return response()->json([
                'status' => true,
                'message' => 'Không tìm thấy phòng chiếu'
            ]);
        }

        $auditoriums->delete();
        $request->session()->flash('success', 'Đã xóa phòng chiếu thành công');
        return response()->json([
            'status' => true,
            'message' => 'Đã xóa phòng chiếu thành công'
        ]);
    }
}
