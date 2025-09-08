@extends('layouts.main_layout',['title'=>'Checkout','breadcrum'=>['Checkout']])

@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4">Checkout</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kursus</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carts as $cart)
            <tr>
                <td>{{ $cart->course->title }}</td>
                <td>Rp {{ number_format($cart->course->price,0,',','.') }}</td>
                <td>{{ $cart->qty }}</td>
                <td>Rp {{ number_format($cart->course->price * $cart->qty,0,',','.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-end fw-bold">Total</td>
                <td class="fw-bold">Rp {{ number_format($total,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>

    <form method="POST" action="{{ route('course.order.store') }}">
        @csrf
        <button type="submit" class="btn btn-success">
            <i class="bi bi-credit-card"></i> Proses Pembayaran
        </button>
    </form>
</div>
@endsection