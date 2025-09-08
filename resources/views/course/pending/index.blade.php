@extends('layouts.main_layout', [
    'title' => 'Menunggu Pembayaran',
    'breadcrum' => ['Checkout - Pending']
])

@section('content')
<div class="container py-5">

    <div class="card shadow-sm p-4 text-center">
        <h2 class="text-warning mb-3">
            <i class="bi bi-hourglass-split"></i> Pembayaran Belum Dikonfirmasi
        </h2>

        <p class="mb-4">
            Order dengan kode <strong>{{ $order->order_code }}</strong> 
            sedang menunggu konfirmasi pembayaran.  
            Silakan selesaikan pembayaran agar kursus bisa diakses.
        </p>

        <div class="mb-4">
            <h5>Total Pembayaran</h5>
            <h3 class="fw-bold text-primary">
                Rp {{ number_format($order->total, 0, ',', '.') }}
            </h3>
        </div>

        {{-- Jika ada info pembayaran --}}
        <div class="alert alert-info text-start mx-auto" style="max-width: 500px;">
            <h6 class="fw-bold">Instruksi Pembayaran:</h6>
            <ul class="mb-0">
                <li>Transfer ke Bank BCA: <strong>1234567890</strong> a.n <strong>PT LMS Indonesia</strong></li>
                <li>Sertakan kode order di berita transfer</li>
                <li>Upload bukti transfer di halaman konfirmasi</li>
            </ul>
        </div>
        <hr>
        <div class="card-body p-0">
            <h5 class="mb-0 fw-bold mb-3 mt-3">Detail Pesanan</h5>
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Kursus</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->order_detail as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index+1 }}</td>
                                <td>{{ $item->course->title ?? '-' }}</td>
                                <td class="text-center">{{ $item->qty }}</td>
                                <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="fw-bold">
                            <td colspan="4" class="text-end">Total</td>
                            <td class="text-end text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ✅ Tambahan: Detail Order --}}
    <div class="card shadow-sm mt-4">
    </div>

</div>
@endsection