<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add_to_cart(Product $product, Request $request) {
        $user_id = Auth::id();
        $product_id = $product->id;

        $exist_cart = Cart::where('product_id', $product_id)
            ->where('user_id', $user_id)
            ->first();

        if ($exist_cart == null) {
            $request->validate([
                'amount' => 'required|gte:1|lte:' . $product->stock
            ]);

            Cart::create([
                'amount' => $request->amount,
                'user_id' => $user_id,
                'product_id' => $product_id
            ]);
        } else {
            $request->validate([
                'amount' => 'required|gte:1|lte:' . ( $product->stock - $exist_cart->amount )
            ]);

            $exist_cart->update([
                'amount' => $exist_cart->amount + $request->amount
            ]);
        }


        return redirect::route('show_cart');
    }

    public function show_cart() {
        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();

        return view('show_cart', compact('carts'));
    }

    public function update_cart(Cart $cart, Request $request) {
        $request->validate([
            'amount' => 'required|gte:1|lte:' . $cart->product->stock
        ]);

        $cart->update([
            'amount' => $request->amount
        ]);

        return redirect::route('show_cart');
    }

    public function delete_cart(Cart $cart) {
        $cart->delete();
        return redirect()->back();
    }
}
