@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
    <link rel="icon" href="{{ asset('img/logo-nav.png') }}" type="image/x-icon">
</head>

<body>
    @section('content')
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        @endif

        @php
            $total_price = 0;
        @endphp

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @if ($carts->isNotEmpty())
                        <h2 class="fw-bold">Cart</h2>
                    @endif

                    <div class="d-flex flex-wrap justify-content-start gap-4">
                        @foreach ($carts as $cart)
                            <div class="card shadow" style="width: 18rem;">
                                <img src="{{ Storage::url($cart->product->image) }}" class="card-img-top product-img">
                                <div class="card-body">
                                    <h5 class="card-title mb-0">{{ $cart->product->name }}</h5>
                                    <h3 class="card-text fw-bold">Rp
                                        {{ number_format($cart->product->price * $cart->amount, 0, ',', '.') }}</h3>
                                    <form action="{{ route('update_cart', $cart) }}" method="post" class="mb-3">
                                        @method('patch')
                                        @csrf
                                        <div class="d-flex justify-content-between">
                                            <input type="number" name="amount" class="form-control" style="width: 43%"
                                                value="{{ $cart->amount }}">
                                            <button type="submit" class="btn btn-secondary">Update Amount</button>
                                        </div>
                                    </form>
                                    <form action="{{ route('delete_cart', $cart) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>

                            @php
                                $total_price += $cart->product->price * $cart->amount;
                            @endphp
                        @endforeach
                    </div>
                    @if ($carts->count() > 0)
                        <form action="{{ route('checkout') }}" method="POST" class="mt-5">
                            @csrf
                            <h5 class="fw-bold">Total : Rp {{ number_format($total_price, 0, ',', '.') }}</h5>
                            <button type="submit" class="btn btn-success">Checkout</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        @if ($carts->isEmpty())
            <div class="d-flex justify-content-center align-items-center" style="height: 80vh">
                @if ($carts->isEmpty())
                    <p>Empty Cart. <a href="{{ route('show_product') }}">Add Now</a></p>
                @endif
            </div>
        @endif
    @endsection
</body>

</html>
