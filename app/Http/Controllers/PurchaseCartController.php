<?php

namespace App\Http\Controllers;

use App\Models\Models\Product;
use Illuminate\Http\Request;

class PurchaseCartController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response(
                $request->user()->purchaseCart()->get()
            );
        }
        return view('purchaseCart.index');
    }

    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id',]);
        $product_id = $request->product_id;
        $product = Product::where('id', $product_id)->first();

        $purchaseCart = $request->user()->purchaseCart()->where('product_id', $product_id)->first();

        if ($purchaseCart) {
            $purchaseCart->pivot->quantity = $purchaseCart->pivot->quantity + 1;
            $purchaseCart->pivot->save();
        } else {
            $request->user()->purchaseCart()->attach($product->id, ['quantity' => 1, 'price' => $product->purchase_price]);
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

        $purchaseCart = $request->user()->purchaseCart()->where('product_id', $product_id)->first();

        if ($purchaseCart) {

            //mise à jour de la qunaité:
            $purchaseCart->pivot->quantity = $qty;
            $purchaseCart->pivot->save();
        }


        return response(['success' => true]);
    }

    public function delete(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id',]);
        $product_id = $request->product_id;

        $purchaseCart = $request->user()->purchaseCart()->detach($product_id);

        return response('', 204);
    }

    public function empty(Request $request)
    {
        $purchaseCart = $request->user()->purchaseCart()->detach();

        return response('', 204);
    }
}
