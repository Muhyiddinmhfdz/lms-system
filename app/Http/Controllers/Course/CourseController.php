<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\CategoryCourse;
use App\Models\Course;
use App\Models\CourseDetail;
use Illuminate\Http\Request;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        return view('course.index');
    }

    public function data(Request $request)
    {
        $data = Course::with('category')->get();
        return DataTables::of($data)->make(true);
    }

    public function create()
    {
        $category = CategoryCourse::where('is_active',1)->get();

        return view('course.create',compact('category'));
    }

    public function insert(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255|unique:courses,title',
            'slug'              => 'required|string|max:255|unique:courses,slug',
            'description'       => 'required|string',
            'category_course_id'=> 'required|exists:category_courses,id',
            'language_id'       => 'required|in:1,2',
            'publisher'         => 'required|string|max:255',
            'working_publisher' => 'required|string|max:255',
            'level_id'          => 'required|in:1,2,3',
            'duration'          => 'required|numeric',
            'price'             => 'required',
            'discount_price'    => 'nullable',
            'path_thumbnail'    => 'required|image|mimes:jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data'   => $this->validationErrorsToString($validator->errors())
            ], 200);
        }

        $filters = [
            'title'             => 'trim|escape',
            'slug'              => 'trim|escape',
            'description'       => 'trim',
            'publisher'         => 'trim|escape',
            'working_publisher' => 'trim|escape',
            'duration'          => 'trim',
            'price'             => 'trim',
            'discount_price'    => 'trim',
        ];

        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean  = $sanitizer->sanitize();

        try{
            DB::beginTransaction();

            // handle file upload thumbnail
            if ($request->hasFile('path_thumbnail')) {
                $file = $request->file('path_thumbnail');
                $path = $file->store('uploads/course_thumbnails', 'public'); 
                $attrclean['path_thumbnail'] = $path;
            }

            $attrclean['duration']       = $this->remove_comma($attrclean['duration']);
            $attrclean['price']          = $this->remove_comma($attrclean['price']);
            $attrclean['discount_price'] = $this->remove_comma($attrclean['discount_price']);
            // insert ke courses
            $course = Course::create($attrclean);

            // simpan repeater detail (jika ada)
            if ($request->has('kt_docs_repeater_basic')) {
                foreach ($request->kt_docs_repeater_basic as $detail) {
                    CourseDetail::create([
                        'course_id'       => $course->id,
                        'sub_title'       => $detail['sub_title'] ?? null,
                        'description' => $detail['sub_description'] ?? null,
                        'url'             => $detail['url'] ?? null,
                    ]);
                }
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e);
            dd($e);
            return response()->json(['status'=>false,'data'=>'Cannot Proccess'], 200);
        }

        return response()->json(['status'=>true,'data'=>$course], 200);
    }
    
    public function edit(Course $course)
    {
        $course->load('details');
        $category = CategoryCourse::where('is_active',1)->get();
        return view('course.edit',compact('category','course'));
    }

    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255|unique:courses,title,' . $course->id,
            'slug'              => 'required|string|max:255|unique:courses,slug,' . $course->id,
            'description'       => 'required|string',
            'category_course_id'=> 'required|exists:category_courses,id',
            'language_id'       => 'required|in:1,2',
            'publisher'         => 'required|string|max:255',
            'working_publisher' => 'required|string|max:255',
            'level_id'          => 'required|in:1,2,3',
            'duration'          => 'required|numeric',
            'price'             => 'required',
            'discount_price'    => 'nullable',
            'path_thumbnail'    => 'nullable|image|mimes:jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data'   => $this->validationErrorsToString($validator->errors())
            ], 200);
        }

        $filters = [
            'title'             => 'trim|escape',
            'slug'              => 'trim|escape',
            'description'       => 'trim',
            'publisher'         => 'trim|escape',
            'working_publisher' => 'trim|escape',
            'duration'          => 'trim',
            'price'             => 'trim',
            'discount_price'    => 'trim',
        ];

        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean  = $sanitizer->sanitize();

        try {
            DB::beginTransaction();

            // handle file upload thumbnail (opsional)
            if ($request->hasFile('path_thumbnail')) {
                // hapus thumbnail lama kalau ada
                if ($course->path_thumbnail && \Storage::disk('public')->exists($course->path_thumbnail)) {
                    \Storage::disk('public')->delete($course->path_thumbnail);
                }
                $file = $request->file('path_thumbnail');
                $path = $file->store('uploads/course_thumbnails', 'public');
                $attrclean['path_thumbnail'] = $path;
            } else {
                $attrclean['path_thumbnail'] = $course->path_thumbnail; // tetap pakai lama
            }

            $attrclean['duration']       = $this->remove_comma($attrclean['duration']);
            $attrclean['price']          = $this->remove_comma($attrclean['price']);
            $attrclean['discount_price'] = $this->remove_comma($attrclean['discount_price']);

            // update course utama
            $course->update($attrclean);

            // handle repeater detail: hapus dulu, lalu insert ulang
            $course->details()->delete();

            if ($request->has('kt_docs_repeater_basic')) {
                foreach ($request->kt_docs_repeater_basic as $detail) {
                    CourseDetail::create([
                        'course_id'   => $course->id,
                        'sub_title'   => $detail['sub_title'] ?? null,
                        'description' => $detail['sub_description'] ?? null,
                        'url'         => $detail['url'] ?? null,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json(['status' => false, 'data' => 'Cannot Process'], 200);
        }

        return response()->json(['status' => true, 'data' => $course], 200);
    }

    public function changeStatus(Course $course)
    {
        if ($course->is_publish == false) {
            $course->is_publish = true;
        } else {
            $course->is_publish = false;
        }
        $course->save();

        return response()->json(['status' => true, 'data' => $course], 200);
    }
}
