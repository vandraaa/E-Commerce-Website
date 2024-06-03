@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit - {{ $product->name }}</title>
    <link rel="icon" href="{{ asset('img/logo-nav.png') }}" type="image/x-icon">

</head>

<body>

    @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <div class="card shadow w-75 mx-auto p-3">
                        <div class="card-title">
                            <h2 class="fw-bold ps-3 pt-2">Edit Product </h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update_product', $product) }}" method="POST" enctype="multipart/form-data">
                                @method('patch')
                                @csrf
                                <label class="mb-1 fs-6">Nama Produk : </label>
                                <input type="text" name="name" class="form-control mb-3" value="{{ $product->name }}"
                                    placeholder="masukkan nama produk...">
                                <label class="mb-1 fs-6">Deskripsi Produk : </label>
                                <textarea name="description" class="form-control mb-3" style="height: 70px;"
                                    placeholder="masukkan deskripsi produk...">{{ $product->description }}</textarea>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="mb-1 fs-6">Harga Produk : </label>
                                        <input type="number" name="price" class="form-control" value="{{ $product->price }}"
                                            placeholder="masukkan harga produk...">
                                    </div>
                                    <div class="col-6">
                                        <label class="mb-1 fs-6">Stok Produk : </label>
                                        <input type="number" name="stock" class="form-control mb-3" value="{{ $product->stock }}"
                                            placeholder="masukkan stok produk">
                                    </div>
                                </div>
                                <label class="mb-1 fs-6">Foto Produk : </label>
                                <br>
                                <div class="row">
                                    <div class="col-3">
                                        <img src="{{ Storage::url($product->image) }}" height="100px" class="mb-3">
                                    </div>
                                    <div class="col-9">
                                        <input type="file" name="image" class="form-control mb-3">
                                        <p class="text-danger">*Jika anda tidak ingin mengganti gambar, maka abaikan upload file</p>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

</body>

</html>
