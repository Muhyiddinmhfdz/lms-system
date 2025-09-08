<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\CategoryCourse;
use App\Models\Course;
use Illuminate\Http\Request;

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
}
