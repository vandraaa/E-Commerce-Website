@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order - {{ $order->id }}</title>
    <link rel="icon" href="{{ asset('img/logo-nav.png') }}" type="image/x-icon">
</head>

<body>
    @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="d-flex gap-4 align-items-center">
                        <a href="{{ route('show_order') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                            </svg>
                        </a>
                        <h2 class="fw-bold mb-0">Detail Order</h2>
                    </div>

                    <div class="d-flex flex-wrap justify-content-start gap-4 mt-3">
                        <div class="card shadow mx-auto py-2 px-3" style="width: 60%;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex gap-1 align-items-center">
                                    @if ($order->is_paid == true && $order->is_shipped == true)
                                        <img src="https://cdn.pixabay.com/photo/2017/01/13/01/22/ok-1976099_640.png" height="60px">
                                    @endif
                                    <h3 class="fw-bold">Order ID : {{ $order->id }}</h3>
                                </div>
                                <div class="fw-bold text-end" style="font-size: 12px;">
                                    <p class="mb-0">Cust : {{ $order->user->name }}</p>
                                    <p>{{ $order->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                            <hr class="mx-3 m-0">
                            <div class="card-body">
                                @foreach ($order->transaction as $trx)
                                    @php
                                        $total_item = $trx->amount * $trx->product->price;
                                    @endphp

                                    <div class="row my-3">
                                        <div class="col-6">
                                            <img src="{{ Storage::url($trx->product->image) }}" class="order-img">
                                        </div>
                                        <div class="col-3 mx-3 mt-2">
                                            <h4 class="fw-bold">{{ $trx->product->name }}</h4>
                                            <p>{{ $trx->amount }} x Rp
                                                {{ number_format($trx->product->price, 0, ',', '.') }}</p>
                                            <h6 class="fw-bold">Total: Rp {{ number_format($total_item, 0, ',', '.') }}</h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="mx-3 mt-0">
                            <div class="card-body my-0">
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-bold">Subtotal : Rp {{ number_format($overall_total, 0, ',', '.') }}</h5>
                                    @if (isset($order->payment_receipt))
                                        <a href="{{ Storage::url($order->payment_receipt) }}"
                                            class="text-decoration-none text-black d-flex gap-1">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                    <path
                                                        d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z" />
                                                </svg>
                                            </div>
                                            <div class="fw-bold" style="font-size: 13.5px">
                                                <p>Bukti Pembayaran</p>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                                @if ($order->is_paid == false && $order->payment_receipt == null)
                                    <p class="text-danger fw-bold">
                                        Status : Belum Dibayar
                                    </p>
                                @elseif ($order->is_paid == false)
                                    <p class="text-body-tertiary fw-bold">
                                        Status : Menunggu Konfirmasi Penjual
                                    </p>
                                @elseif ($order->is_paid == true && $order->is_shipped == false)
                                    <p class="text-success fw-bold">
                                        Status : Pembayaran dikonfirmasi! barang akan segera di kirim!
                                    </p>
                                @elseif ($order->is_shipped == true && $order->is_paid == true)
                                    <p class="text-success fw-bold">
                                        Status : Barang berhasil dikirim!
                                    </p>
                                @endif
                            </div>
                            <hr class="mx-3 m-0">
                            <div class="card-body">
                                @if (!Auth::user()->is_admin)
                                    @if ($order->is_paid == false && $order->payment_receipt == null)
                                        <form action="{{ route('submit_payment_receipt', $order) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label class="fw-bold">Upload Your Payment Receipt</label>
                                            <input type="file" name="payment_receipt" class="form-control">
                                            <div class="d-flex justify-content-end mt-3">
                                                <button class="btn btn-primary" type="submit">Submit Receipt</button>
                                            </div>
                                        </form>
                                    @endif
                                @endif
                                <div class="text-end">
                                    @if (Auth::user()->is_admin)
                                        @if ($order->is_paid == false && isset($order->payment_receipt))
                                            <form action="{{ route('confirm_payment', $order) }}" method="post">
                                                @csrf
                                                <button class="btn btn-success" type="submit">Confirm Payment</button>
                                            </form>
                                        @elseif ($order->is_paid == true && $order->is_shipped == false)
                                            <form action="{{ route('confirm_shipped', $order) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Confirm Shipped</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</body>

</html>
