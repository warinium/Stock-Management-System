<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        /* $orders = Order::latest()->paginate(10); */
        $orders = new Order();

        if ($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date);
        }
        $orders = $orders->with(['items', 'payments', 'customer'])->latest()->paginate(10);

        $totalGeneral = $orders->map(function ($i) {
            return $i->getAmount();
        })->sum();

        $totalPayementGeneral = $orders->map(function ($i) {
            return $i->getReceivedAmount();
        })->sum();
        return view('orders.index', compact('orders', 'totalGeneral', 'totalPayementGeneral'));
    }

    public function store(OrderStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::create(['customer_id' => $request->customer_id, 'user_id' => $request->user()->id]);

            $cart = $request->user()->cart()->get();


            foreach ($cart as $item) {
                $order->items()->create(['price' => $item->price, 'quantity' => $item->pivot->quantity, 'product_id' => $item->id]);
                $item->save();
            }

            $request->user()->cart()->detach();

            $order->payments()->create(['amount' => $request->amount, 'user_id' => $request->user()->id]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['success' => true]);
    }
}
