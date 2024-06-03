@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Product</title>
    <link rel="icon" href="{{ asset('img/logo-nav.png') }}" type="image/x-icon">

</head>

<body>

    @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <div class="card shadow w-75 mx-auto p-3">
                        <div class="card-title">
                            <h2 class="fw-bold ps-3 pt-2">Create Product</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store_product') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label class="mb-1 fs-6">Nama Produk : </label>
                                <input type="text" name="name" class="form-control mb-3"
                                    placeholder="masukkan nama produk...">
                                <label class="mb-1 fs-6">Deskripsi Produk : </label>
                                <textarea type="text" name="description" class="form-control mb-3" style="height: 70px;"
                                    placeholder="masukkan deskripsi produk..."></textarea>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1 fs-6">Harga Produk : </label>
                                        <input type="number" name="price" class="form-control"
                                            placeholder="masukkan harga produk...">
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1 fs-6">Stok Produk : </label>
                                        <input type="number" name="stock" class="form-control mb-3"
                                            placeholder="masukkan stok produk">
                                    </div>
                                </div>
                                <label class="mb-1 fs-6">Foto Produk : </label>
                                <input type="file" name="image" class="form-control mb-3">
                                <button type="submit" class="btn btn-success">Create Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

</body>

</html>
