<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Age;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgeController extends Controller
{
    public function index(Request $request)
    {
        $ages = Age::latest();
        if (!empty($request->get('keyword'))){
            $ages = $ages->where('name', 'like', '%'.$request->get('keyword').'%' );
        }
        $ages = $ages->paginate(10);
        return view('admin.age_manager.index', [
            'ages' => $ages,
        ]);
    }

    public function create()
    {
        return view('admin.age_manager.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->passes()){
            $age = new Age();
            $age->name = $request->name;
            $age->save();

            $request->session()->flash('success', 'Age added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Age added successfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($ageId, Request $request)
    {
        $age = Age::find($ageId);
        if (empty($age)){
            $request->session()->flash('error', 'Age not found');
            return redirect()->route('age.index');
        }
        $data['age'] = $age;
        return view('admin.age_manager.edit', $data);
    }

    public function update($ageId, Request $request)
    {
        $age = Age::find($ageId);
        if (empty($age)){
            $request->session()->flash('error', 'Age not found');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Age not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->passes()){
            $age->name = $request->name;
            $age->save();

            $request->session()->flash('success', 'Age updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Age updated successfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($ageId, Request $request)
    {
        $age = Age::find($ageId);
        if (empty($age)){
            $request->session()->flash('error', 'Age not found');
            return response()->json([
                'status' => true,
                'message' => 'Age not found'
            ]);
        }

        $age->delete();
        $request->session()->flash('success', 'Age deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Age deleted successfully'
        ]);
    }
}
