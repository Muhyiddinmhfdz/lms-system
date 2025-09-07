<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\CategoryCourse;
use Illuminate\Http\Request;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CategoryCourseController extends Controller
{
    //
    public function index()
    {
        return view('course.category.index');
    }

    public function data(Request $request)
    {
        $education = CategoryCourse::query();
        (!is_null($request->name)) ? $education->where('name','like','%'.$request->name.'%') : '';

        return DataTables::of($education)->make(true);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:category_courses,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'name'    =>  'trim|escape',
        ];
        // dd($attrclean);
        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        $category=CategoryCourse::create($attrclean);

        return response()->json(['status'=>true,'data'=>$category], 200);
    }

    public function detail(CategoryCourse $category)
    {
        return response()->json(['status' => true, 'data' => $category], 200);
    }

    public function update(CategoryCourse $category, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>[
                'required',
                Rule::unique('category_courses')->ignore($category->id)
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'name'    =>  'trim|escape',
        ];
        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        $category->name=$attrclean['name'];

        $category->save();
        
        return response()->json(['status'=>true,'data'=>$category], 200);
    }

    public function changeStatus(CategoryCourse $category)
    {
        if ($category->is_active == false) {
            $category->is_active = true;
        } else {
            $category->is_active = false;
        }
        $category->save();

        return response()->json(['status' => true, 'data' => $category], 200);
    }
}
