<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;

class OrderController extends Controller
{
    public function checkout() {
        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();

        if($carts == null) {
            return redirect()->back();
        }

        $order = Order::create([
            'user_id' => $user_id
        ]);

        foreach ($carts as $cart) {

            $product = Product::find($cart->product_id);
            $product->update([
                'stock' => $product->stock - $cart->amount
            ]);

            Transaction::create([
                'amount' => $cart->amount,
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
            ]);

            Cart::where('user_id', $user_id)->delete();
        }


        return Redirect::route('show_detail_order', ['order' => $order->id]);
    }

    public function show_order(Request $request) {
        $user = Auth::user();
        $is_admin = $user->is_admin;
        if ($is_admin) {
            $orders = Order::orderBy('created_at', 'desc')->get();
        } else {
            $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        }

        // query
        $query = Order::query();

        // filter
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'all':
                    break;
                case 'belum_dibayar':
                    $query->where('is_paid', false)->whereNull('payment_receipt');
                    break;
                case 'menunggu_konfirmasi':
                    $query->where('is_paid', false)->whereNotNull('payment_receipt');
                    break;
                case 'dikonfirmasi':
                    $query->where('is_paid', true)->where('is_shipped', false);
                    break;
                case 'barang_dikirim':
                    $query->where('is_shipped', true);
                    break;
            }
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return view('show_order', compact('orders'));
    }

    public function show_detail_order(Order $order) {
        $overall_total = 0;

        foreach($order->transaction as $trx) {
            $total_item = $trx->amount * $trx->product->price;
            $overall_total += $total_item;
        }

        $user = Auth::user();
        $is_admin = $user->is_admin;

        if ($is_admin || $user->id) {
            return view('show_detail_order', compact('order', 'overall_total'));
        }

        return redirect()->back();
    }

    public function submit_payment_receipt(Order $order, Request $request) {
        $file = $request->file('payment_receipt');
        $extension = $file->getClientOriginalExtension();
        $path = time() . '_' . $order->id . '.' . $extension;

        Storage::disk('public')->put($path, file_get_contents($file));

        $order->update([
            'payment_receipt' => $path
        ]);

        return redirect()->back();
    }

    public function confirm_payment(Order $order) {
        $order->update([
            'is_paid' => true
        ]);

        return redirect()->back();
    }

    public function confirm_shipped(Order $order) {
        $order->update([
            'is_shipped' => true
        ]);

        return redirect()->back();
    }

}
