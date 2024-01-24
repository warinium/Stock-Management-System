<?php

namespace App\Http\Controllers;

use App\Models\Models\Customer;
use App\Models\Models\Order;
use App\Models\Models\Provider;
use App\Models\Models\Purchase;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Order::with(['items', 'payments'])->get();
        $purchases = Purchase::with(['items', 'payments'])->get();
        $customers_count = Customer::count();
        $providers_count = Provider::count();

        return view('home', [
            'purchases_count' => $purchases->count(),
            'outcome' => $purchases->map(function ($i) {
                if ($i->getReceivedAmount() > $i->getAmount()) {
                    return $i->getAmount();
                }
                return $i->getReceivedAmount();
            })->sum(),
            'outcome_today' => $purchases->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->map(function ($i) {
                if ($i->getReceivedAmount() > $i->getAmount()) {
                    return $i->getAmount();
                }
                return $i->getReceivedAmount();
            })->sum(),

            'income_today' => $purchases->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->map(function ($i) {
                if ($i->getReceivedAmount() > $i->getAmount()) {
                    return $i->getAmount();
                }
                return $i->getReceivedAmount();
            })->sum(),


            'orders_count' => $orders->count(),
            'income' => $orders->map(function ($i) {
                if ($i->getReceivedAmount() > $i->getAmount()) {
                    return $i->getAmount();
                }
                return $i->getReceivedAmount();
            })->sum(),
            'income_today' => $orders->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->map(function ($i) {
                if ($i->getReceivedAmount() > $i->getAmount()) {
                    return $i->getAmount();
                }
                return $i->getReceivedAmount();
            })->sum(),
            'customers_count' => $customers_count,
            'providers_count' => $providers_count,
        ]);
    }
}
