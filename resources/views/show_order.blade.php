@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order</title>
    <link rel="icon" href="{{ asset('img/logo-nav.png') }}" type="image/x-icon">
</head>

<body>
    @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <div class="d-flex justify-content-between">
                        <h2 class="fw-bold">Order</h2>

                        <div>
                            <form action="{{ route('show_order') }}" method="get" class="d-flex">
                                <select class="form-control" name="filter">
                                    <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="belum_dibayar"
                                        {{ request('filter') == 'belum_dibayar' ? 'selected' : '' }}>Belum
                                        Dibayar</option>
                                    <option value="menunggu_konfirmasi"
                                        {{ request('filter') == 'menunggu_konfirmasi' ? 'selected' : '' }}>
                                        Menunggu Konfirmasi</option>
                                    <option value="dikonfirmasi"
                                        {{ request('filter') == 'dikonfirmasi' ? 'selected' : '' }}>
                                        Belum dikirim</option>
                                    <option value="barang_dikirim"
                                        {{ request('filter') == 'barang_dikirim' ? 'selected' : '' }}>
                                        Berhasil dikirim</option>
                                </select>

                                <button type="submit" class="btn btn-primary ms-2">Filter</button>
                            </form>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        @foreach ($orders as $order)
                            <a href="{{ route('show_detail_order', $order) }}" class="text-decoration-none">
                                <div class="col-6 w-100">
                                    <div class="card shadow-sm h-100 ">
                                        <div class="card-header d-flex bg-secondary text-white align-items-center">
                                            @if ($order->is_paid == true && $order->is_shipped == true)
                                                <div>
                                                    <img src="https://cdn.pixabay.com/photo/2017/01/13/01/22/ok-1976099_640.png"
                                                        height="30px">
                                                </div>
                                            @endif
                                            <div>
                                                <h5 class="mb-0 fw-bold">Order ID: {{ $order->id }}</h5>
                                            </div>
                                        </div>
                                        <div class="card-body text-black">
                                            <p class="mb-2 fw-bold">User : {{ $order->user->name }}</p>
                                            <p class="mb-2 fw-bold">Order Date : {{ $order->created_at->format('d F Y') }}
                                            </p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between align-items-center">
                                            <div class="mt-3">
                                                @if ($order->is_paid == false && $order->payment_receipt == null)
                                                    <p class="text-danger fw-bold">
                                                        Belum Dibayar
                                                    </p>
                                                @elseif ($order->is_paid == false)
                                                    <p class="text-body-tertiary fw-bold">
                                                        Menunggu Konfirmasi Penjual
                                                    </p>
                                                @elseif ($order->is_paid == true && $order->is_shipped == false)
                                                    <p class="text-success fw-bold">
                                                        Pembayaran dikonfirmasi! barang akan segera di kirim!
                                                    </p>
                                                @elseif ($order->is_shipped == true && $order->is_paid == true)
                                                    <p class="text-success fw-bold">
                                                        Barang berhasil dikirim!
                                                    </p>
                                                @endif
                                            </div>
                                            <div>
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('show_detail_order', $order) }}">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        @if ($orders->isEmpty())
            <div class="d-flex justify-content-center align-items-center" style="height: 80vh">
                @if (Auth::check())
                    @if (Auth::user()->is_admin)
                        <p>Order Not Available</p>
                    @else
                        <p>Order Not Available</p>
                    @endif
                @else
                    <p>Order Not Available</p>
                @endif
            </div>
        @endif
    @endsection
</body>

</html>
