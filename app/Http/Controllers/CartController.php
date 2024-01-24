<?php

namespace App\Http\Controllers;

use App\Models\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response(
                $request->user()->cart()->get()
            );
        }
        return view('cart.index');
    }

    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id',]);
        $product_id = $request->product_id;
        $product = Product::where('id', $product_id)->first();

        $cart = $request->user()->cart()->where('product_id', $product_id)->first();

        if ($cart) {
            if ($product['quantity'] <= $cart->pivot->quantity) {
                return response(['error' => true, 'message' => 'Unavailable stock'], 403);
            } //Incrementer la qunaité:
            $cart->pivot->quantity = $cart->pivot->quantity + 1;
            $cart->pivot->save();
        } else {
            if ($product['quantity'] > 0) {
                $request->user()->cart()->attach($product->id, ['quantity' => 1]);
            } else
                return response(['error' => true, 'message' => 'Unavailable stock'], 403);
        }


        return response('', 204);
    }


    public function changeQty(Request $request)
    {
        $request->validate(['quantity' => 'required|integer|min:1',]);
        $request->validate(['product_id' => 'required|exists:products,id',]);
        $qty = $request->quantity;
        $product_id = $request->product_id;
        $product = Product::where('id', $product_id)->first();

        $cart = $request->user()->cart()->where('product_id', $product_id)->first();

        if ($cart) {
            if ($product['quantity'] < $qty) {
                return response(['error' => true, 'message' => 'Unavailable stock'], 403);
            } //Incrementer la qunaité:

            //mise à jour de la qunaité:
            $cart->pivot->quantity = $qty;
            $cart->pivot->save();
        }/*  else {
            $request->user()->cart()->attach($product->id, ['quantity' => 1]);
        } */


        return response(['success' => true]);
    }

    public function delete(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id',]);
        $product_id = $request->product_id;

        $cart = $request->user()->cart()->detach($product_id);

        return response('', 204);
    }

    public function empty(Request $request)
    {
        $cart = $request->user()->cart()->detach();

        return response('', 204);
    }
}
