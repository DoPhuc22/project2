<?php

namespace App\Http\Controllers\admin;

use App\Models\Food;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $foods = Food::latest();

        if (!empty($request->get('keyword'))) {
            $foods = $foods->where('name', 'like', '%' . $request->get('keyword') . '%');
        }

        $foods = $foods->paginate(14);

        return view('admin.food_manager.index', [
            'foods' => $foods,
        ]);
    }
    public function create(){
        return view('admin.food_manager.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required', // Ensures price is numeric
        ]);

        if ($validator->passes()) {
            $food = new Food();
            $food->name = $request->name;
            $food->description = $request->description;
            $food->price = $request->price;
            $food->status = $request->status;
            $food->save();

            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $food->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/food/'.$newImageName;
                File::copy($sPath, $dPath);
                $food->image = $newImageName;
                $food->save();
            }


            $request->session()->flash('success', 'Food added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Food added successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($foodId, Request $request)
    {
        $food = Food::find($foodId);

        if (empty($food)) {
            $request->session()->flash('error', 'Food not found');
            return redirect()->route('food.index');
        }

        $data['food'] = $food;
        return view('admin.food_manager.edit', $data);
    }

    public function update($foodId, Request $request)
    {
        $food = Food::find($foodId);

        if (empty($food)) {
            $request->session()->flash('error', 'Food not found');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Food not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
        ]);

        if ($validator->passes()) {
            $food->name = $request->name;
            $food->description = $request->description;
            $food->price = $request->price;
            $food->status = $request->status;
            $food->save();
            $oldImage = $food->image;

            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $food->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/food/'.$newImageName;
                File::copy($sPath, $dPath);

                $food->image = $newImageName;
                $food->save();

                // DELETE old image here
                File::delete(public_path().'/temp/'.$oldImage);
                File::delete(public_path().'/uploads/food/'.$oldImage);
            }

            $request->session()->flash('success', 'Food updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Food updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
