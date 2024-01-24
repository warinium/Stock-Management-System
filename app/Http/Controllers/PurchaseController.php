<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseStoreRequest;
use App\Models\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        /* $purchases = Purchase::latest()->paginate(10); */
        $purchases = new Purchase();

        if ($request->start_date) {
            $purchases = $purchases->where('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $purchases = $purchases->where('created_at', '<=', $request->end_date);
        }

        $purchases = $purchases->with(['items', 'payments', 'provider'])->latest()->paginate(10);

        $totalGeneral = $purchases->map(function ($i) {
            return $i->getAmount();
        })->sum();

        $totalPayementGeneral = $purchases->map(function ($i) {
            return $i->getReceivedAmount();
        })->sum();

        return view('purchases.index', compact('purchases', 'totalGeneral', 'totalPayementGeneral'));
    }

    public function store(PurchaseStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::create(['provider_id' => $request->provider_id, 'user_id' => $request->user()->id]);
            $cart = $request->user()->purchaseCart()->get();

            foreach ($cart as $item) {
                $purchase->items()->create(['price' => $item->purchase_price, 'quantity' => $item->pivot->quantity, 'product_id' => $item->id]);
                $item->save();
            }

            $request->user()->purchaseCart()->detach();

            $purchase->payments()->create(['amount' => $request->amount, 'user_id' => $request->user()->id]);
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
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return response()->json(['success' => true]);
    }
}
