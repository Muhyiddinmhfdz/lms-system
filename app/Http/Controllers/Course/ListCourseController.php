<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\CategoryCourse;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class ListCourseController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Course::with(['category', 'details']);

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category_course_id', $request->category);
        }

        // Filter by Level
        if ($request->filled('level')) {
            $query->where('level_id', $request->level);
        }

        // Filter by Harga (contoh: max100000)
        if ($request->filled('price')) {
            if ($request->price == 'low') {
                $query->where('discount_price', '<=', 100000)
                    ->orWhere(function ($q) {
                        $q->whereNull('discount_price')
                            ->where('price', '<=', 100000);
                    });
            } elseif ($request->price == 'high') {
                $query->where('discount_price', '>', 100000)
                    ->orWhere(function ($q) {
                        $q->whereNull('discount_price')
                            ->where('price', '>', 100000);
                    });
            }
        }

        // Pagination
        $courses = $query->paginate(6)->appends($request->all());

        // Data tambahan untuk filter dropdown
        $categories = CategoryCourse::all();
        $levels = [
            1 => 'Beginner',
            2 => 'Intermediate',
            3 => 'Advanced',
        ];
        return view('course.student.list',compact('courses','categories','levels'));

    }

    public function detail($slug)
    {
        $course = Course::with(['details', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('course.student.detail', compact('course'));
    }

    public function order()
    {
        return view('course.order.list');
    }

    public function data_order(Request $request)
    {
        $course = Order::query();

        // Jika bukan superadmin → filter by user_id
        if (!Auth::user()->hasRole('Super Admin')) {
            $course->where('user_id', Auth::user()->id);
        }

        // Filter berdasarkan order_code kalau ada input name
        if (!is_null($request->name)) {
            $course->where('order_code', 'like', '%' . $request->name . '%');
        }

        return DataTables::of($course)->make(true);
    }
    
    public function update_order(Order $order)
    {
        $order->status = true;
        $order->save();

        return response()->json(['status'=>true,'data'=>$order], 200);

    }
}
