<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Education;
use Illuminate\Http\Request;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class DepartementController extends Controller
{
    public function index()
    {
        $education = Education::where('is_active',1)->get();
        return view('master.departement.index',compact('education'));
    }

    public function data(Request $request)
    {
        $departement = Departement::with('education');
        (!is_null($request->name)) ? $departement->where('name','like','%'.$request->name.'%') : '';

        return DataTables::of($departement)->make(true);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:education,name',
            'education_id'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'name'=>'trim|escape',
            'education_id'=>'trim|escape',
        ];
        // dd($attrclean);
        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        $departement=Departement::create($attrclean);

        return response()->json(['status'=>true,'data'=>$departement], 200);
    }

    public function detail(Departement $departement)
    {
        return response()->json(['status' => true, 'data' => $departement], 200);
    }

    public function update(Departement $departement, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>[
                'required',
                Rule::unique('departements')->ignore($departement->id)
            ],
             'education_id'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'name'=>'trim|escape',
            'education_id'=>'trim|escape',
        ];
        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        $departement->name=$attrclean['name'];
        $departement->education_id=$attrclean['education_id'];

        $departement->save();
        
        return response()->json(['status'=>true,'data'=>$departement], 200);
    }

    public function changeStatus(Departement $departement)
    {
        if ($departement->is_active == false) {
            $departement->is_active = true;
        } else {
            $departement->is_active = false;
        }
        $departement->save();

        return response()->json(['status' => true, 'data' => $departement], 200);
    }
}
