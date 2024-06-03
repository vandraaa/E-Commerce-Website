@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product - {{ $product->name }}</title>
    <link rel="icon" href="{{ asset('img/logo-nav.png') }}" type="image/x-icon">
</head>

<body>

    @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="d-flex gap-4 align-items-center">
                        <a href="{{ route('show_product') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                            </svg>
                        </a>
                        <h2 class="fw-bold mb-0">Detail Product</h2>
                    </div>

                    <div class="d-flex mt-5 gap-5">
                        <div>
                            <img src="{{ Storage::url($product->image) }}" height="350px">
                        </div>
                        <div>
                            <h2 class="fw-bold fs-1">{{ $product->name }}</h2>
                            <p>{{ $product->description }}</p>
                            <h3 class="fw-bold fs-2">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                            <p>Stock : {{ $product->stock }}</p>
                            @if (!Auth::user()->is_admin)
                                @if ( $product->stock == 0 )
                                    <form style="width: 24rem">
                                        @csrf
                                        <div class="d-flex gap-2">
                                            <input type="number" name="amount" value="1" class="w-25 form-control">
                                            <button class="btn btn-secondary">Add To Cart</button>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('add_to_cart', $product) }}" method="post" style="width: 24rem">
                                        @csrf
                                        <div class="d-flex gap-2">
                                            <input type="number" name="amount" value="1" class="w-25 form-control">
                                            <button type="submit" class="btn btn-success">Add To Cart</button>
                                        </div>
                                    </form>
                                @endif
                            @endif
                            <div class="text-danger mt-2 p-0">
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div>
                            @if (Auth::user()->is_admin)
                                <a href="{{ route('edit_product', $product) }}" class="btn btn-secondary">Edit Product</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
</body>

</html>
