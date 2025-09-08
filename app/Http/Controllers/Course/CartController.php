<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::user()->id, 'course_id' => $course->id],
            ['qty' => 1]
        );

        return redirect()->back()->with('success', 'Kursus berhasil ditambahkan ke keranjang!');
    }

    public function checkout(Course $course)
    {
        $carts = Cart::with('course')->where('user_id', Auth::user()->id)->get();

        $total = $carts->sum(function ($cart) {
            return $cart->course->price * $cart->qty;
        });


        return view('course.cart.index', compact('carts', 'total'));
    }

    public function index()
    {
        $carts = Cart::with('course')->where('user_id', Auth::user()->id)->get();
        return view('course.cart.index', compact('carts'));
    }
}
