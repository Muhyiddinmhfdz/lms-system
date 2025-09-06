<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class EducationController extends Controller
{
    //
    public function index()
    {
        return view('master.education.index');
    }

    public function data(Request $request)
    {
        $education = Education::query();
        (!is_null($request->name)) ? $education->where('name','like','%'.$request->name.'%') : '';

        return DataTables::of($education)->make(true);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:education,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'name'=>'trim',
        ];
        // dd($attrclean);
        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        $education=Education::create($attrclean);

        return response()->json(['status'=>true,'data'=>$education], 200);
    }

    public function detail(Education $education)
    {
        return response()->json(['status' => true, 'data' => $education], 200);
    }

    public function update(Education $education, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>[
                'required',
                Rule::unique('education')->ignore($education->id)
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'name'=>'trim',
        ];
        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        $education->name=$attrclean['name'];

        $education->save();
        
        return response()->json(['status'=>true,'data'=>$education], 200);
    }

    public function changeStatus(Education $education)
    {
        if ($education->is_active == false) {
            $education->is_active = true;
        } else {
            $education->is_active = false;
        }
        $education->save();

        return response()->json(['status' => true, 'data' => $education], 200);
    }
}
