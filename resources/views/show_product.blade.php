@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo-nav.png') }}" type="image/x-icon">
</head>


<body>

    @section('content')

        <div class="container d-flex justify-content-center align-items-center" style="height: 75vh">
            <div>
                <h1 class="fw-bold" style="font-size: 65px">Flash Deals <i class="fas fa-bolt"></i></h1>
                <p style="font-size: 20px">
                    Flash Deals often feature exclusive items that you won't find at these prices anywhere else. Get access
                    to special promotions and products that are only available during these flash sales.
                </p>
            </div>
            <img src="{{ asset('img/1x1.png') }}" style="height: 600px;">
        </div>


        <div class="container" style="margin-top: 150px">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @if ($products->isNotEmpty())
                        <h2 class="fw-bold mb-3 text-center" style="font-size: 45px">Product</h2>
                    @endif

                    <div class="d-flex flex-wrap justify-content-start gap-5">
                        @foreach ($products as $product)
                            @if ($product->stock > 0)
                                <div class="card shadow" style="width: 18rem;">
                                    <a href="{{ route('show_detail_product', $product) }}" class="text-decoration-none">
                                        <img src="{{ Storage::url($product->image) }}" class="card-img-top product-img">
                                        <div class="card-body">
                                            <h5 class="card-title mb-0 text-black">{{ $product->name }}</h5>
                                            <h3 class="card-text fw-bold text-black">Rp
                                                {{ number_format($product->price, 0, ',', '.') }}
                                            </h3>
                                            <div class="d-flex mt-3">
                                                <a href="{{ route('show_detail_product', $product) }}"
                                                    class="btn btn-primary">Detail
                                                    Product</a>
                                                @if (Auth::check() && Auth::user()->is_admin)
                                                    <form action="{{ route('destroy_product', $product) }}" method="POST">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger ms-2">Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @if ($products->isEmpty())
            <div class="d-flex justify-content-center align-items-center" style="height: 80vh">
                @if (Auth::check())
                    @if (Auth::user()->is_admin)
                        <p>Product Not Available. Please Add A New Product</p>
                    @else
                        <p>Product Not Available</p>
                    @endif
                @else
                    <p>Product Not Available</p>
                @endif
            </div>
        @endif

        {{-- Stock Kosong --}}
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @if ($products->where('stock', 0)->isNotEmpty())
                        <h2 class="fw-bold mb-3">Out of Stock</h2>
                        <div class="d-flex flex-wrap justify-content-start gap-5">
                            @foreach ($products->where('stock', 0) as $product)
                                <div class="card shadow" style="width: 18rem;">
                                    <a href="{{ route('show_detail_product', $product) }}" class="text-decoration-none">
                                        <img src="{{ Storage::url($product->image) }}" class="card-img-top product-img">
                                        <div class="card-body">
                                            <h5 class="card-title mb-0 text-black">{{ $product->name }}</h5>
                                            <div class="text-danger fw-bold">Out of Stock</div>
                                            <h3 class="card-text fw-bold text-black">Rp
                                                {{ number_format($product->price, 0, ',', '.') }}
                                            </h3>
                                            <div class="d-flex mt-3">
                                                <a href="{{ route('show_detail_product', $product) }}"
                                                    class="btn btn-primary">Detail Product</a>
                                                @if (Auth::check() && Auth::user()->is_admin)
                                                    <form action="{{ route('destroy_product', $product) }}" method="POST"
                                                        class="ml-2">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger ms-2">Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection

</body>

</html>
