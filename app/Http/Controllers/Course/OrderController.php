<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $carts = Cart::with('course')->where('user_id',Auth::user()->id)->get();

            if ($carts->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
            }

            $total = $carts->sum(fn($c) => $c->course->price * $c->qty);

            // Buat order
            $order = Order::create([
                'user_id'   =>Auth::user()->id,
                'order_code'=> 'ORD-' . strtoupper(Str::random(8)),
                'total'     => $total,
                'status'    => 0,
            ]);

            // Simpan item
            foreach ($carts as $cart) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'course_id'=> $cart->course_id,
                    'qty'      => $cart->qty,
                    'price'    => $cart->course->price,
                    'subtotal' => $cart->course->price * $cart->qty,
                ]);
            }

            // Kosongkan keranjang
            Cart::where('user_id', Auth::user()->id)->delete();

            DB::commit();
            // Redirect ke halaman pembayaran
            return redirect()->route('course.order.pending', $order->id)
                            ->with('success', 'Order berhasil dibuat, silakan lanjutkan pembayaran.');
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e);
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat order. Coba lagi.');
        }

        return response()->json(['status'=>true,'data'=>$course], 200);
    }

    public function pending(Order $order)
    {
        $order->load('order_detail');
        if ($order->status !== 0) {
            return redirect()->route('course.my_course')
                            ->with('success', 'Course telah di Approve,Silahkan lihat di My Course.');
        }
        return view('course.pending.index', compact('order'));
    }
}
