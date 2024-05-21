<?php

namespace App\Http\Controllers\admin;

use App\Models\Seat;
use App\Models\Auditorium;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SeatType;
use Illuminate\Support\Facades\Validator;

class SeatController extends Controller
{
    public function index(Request $request){
        $seats = Seat::orderBy('number_of_col','desc')->orderBy('id','desc');
        if (!empty($seats->get('number_of_row'))){
            $seats = $seats->where('number_of_row', 'like', '%'.$request->get('number_of_row').'%' );
        }
        $seats = $seats->paginate(10);

        return view('admin.seat_manager.index', ['seats' => $seats]);
    }
    public function create()
    {
        $auditoriums = Auditorium::all();
        return view('admin.seat_manager.create',['auditoriums' => $auditoriums]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number_of_row' => 'required',
            'number_of_col' => 'required',
            'auditorium_id' => 'required'
        ]);
        $id = $request->auditorium_id;
        $auditorium = Auditorium::find($id);
        if($request->number_of_col * $request->number_of_row != $auditorium->capacity){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        else{
            if ($validator->passes()){
                for ($j = 1; $j <= $request->number_of_col; $j++) {
                    for ($i = 1; $i <= $request->number_of_row; $i++) {
                        $seat = new Seat;
                        $seat->number_of_row = $i;
                        $seat->number_of_col = $j;
                        $seat->auditorium_id = $request->auditorium_id;
                        $seat->type_id = 1;
                        $seat->status = 1;
                        $seat->save();
                    }
                }
                $request->session()->flash('success', 'Đã thêm ghế thành công');
                return response()->json([
                    'status' => true,
                    'message' => 'Đã thêm ghế thành công'
                ]);

            }else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
        }
    }
    public function change(Seat $seats){
        $auditoriums = Auditorium::all();
        $types = SeatType::all();
        return view('admin.seat_manager.change',compact('auditoriums','seats','types'));
    }

    public function changeStore(Request $request){

        $validator = Validator::make($request->all(), [
            'pointA' => 'required',
            'pointB' => 'required',
            'pointC' => 'required',
            'pointD' => 'required',
            'auditorium_id' => 'required',
            'type_id' => 'required',
        ]);

        if ($validator->passes()){

            $startingRow = $request -> pointA;
            $endRow = $request -> pointB;
            $startingCol = $request ->pointC;
            $endCol = $request -> pointD;
            $auditorium = $request -> auditorium_id;

            $seats = Seat::where('auditorium_id', '=',$auditorium)
                ->whereBetween('number_of_row', [$startingRow, $endRow])
                ->whereBetween('number_of_col', [$startingCol, $endCol])
                ->get();

            foreach($seats as $seat){
                $seat -> type_id = $request -> type_id;
                $seat -> save();
            }
            $request->session()->flash('success', 'Đã cập nhật thông tin ghế thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật thông tin ghế thành công'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function update($seatId, Request $request)
    {
        $seat = Seat::find($seatId);
        if (empty($seat)){
            $request->session()->flash('error', 'Không tìm thấy ghế');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Không tìm thấy ghế'
            ]);
        }

        $validator = Validator::make($request->all(), [
            //    'number_of_row' => 'required',
            //    'number_of_col' => 'required',
            //    'auditorium_id' => 'required'
            'status' => 'required'
        ]);
        if ($validator->passes()){
            // $seat-> number_of_row = $request->number_of_row;
            // $seat-> number_of_col = $request->number_of_col;
            // $seat-> auditorium_id = $request->auditorium_id;
            $seat-> status = $request ->status;
            $seat->save();
            // Status = 2 (la bị hỏng) , 3 là đã đặt, 1 là còn trống
            $request->session()->flash('success', 'Đã cập nhật thông tin ghế thành công');
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật thông tin ghế thành công'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($seatId, Request $request)
    {
        $seat = Seat::find($seatId);
        if (empty($seat)) {
            $request->session()->flash('error', 'Không tìm thấy ghế');
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy ghế'
            ]);
        }

        $seat->delete();
        $request->session()->flash('success', 'Đã xóa ghế thành công');
        return response()->json([
            'status' => true,
            'message' => 'Đã xóa ghế thành công'
        ]);
    }
}
