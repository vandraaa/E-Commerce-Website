<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function create_product() {
        return view('create_product');
    }

    public function store_product(Request $request) {
        $request -> validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $path = time() . '_' . $request->name . '.' . $extension;

        Storage::disk('public')->put($path, file_get_contents($file));

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $path,
        ]);

        return redirect::route('show_product');
    }

    public function show_product() {
        $products = Product::all();
        return view('show_product', compact('products'));
    }

    public function show_detail_product(Product $product) {
        return view('show_detail_product', compact('product'));
    }

    public function edit_product(Product $product) {
        return view('edit_product', compact('product'));
    }

    public function update_product(Product $product ,Request $request) {
        $request -> validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $path = time() . '_' . $request->name . '.' . $extension;

            Storage::disk('public')->put($path, file_get_contents($file));

            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'description' => $request->description,
                'image' => $path,
            ]);
        } else {
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'description' => $request->description,
            ]);
        }

        return redirect::route('show_detail_product', $product);
    }

    public function destroy_product(Product $product) {
        $product->delete();
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return redirect()->back();
    }
}
