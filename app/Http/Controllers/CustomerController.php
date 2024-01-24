<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Models\Customer;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->paginate(10);


        if (request()->wantsJson()) {
            return response(Customer::all());
        }
        return view('customers.index')->with('customers', $customers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerStoreRequest $request)
    {

        $image_file_path = '';
        if ($request->hasFile('avatar')) {
            $image_file_path = $request->file('avatar')->store('customers');
        }
        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'avatar' => $image_file_path,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_id' => $request->user()->id,

        ]);


        if (!$customer) {
            return redirect()->back()->width('error', 'sorry there was a problem creating the customer');
        } else {
            return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {

        return view('customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        //dd($request->status);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->email = $request->email;

        if ($request->has('avatar')) {
            if ($customer->avatar) {
                Storage::delete($customer->avatar);
            }
            $image_path = $request->file('avatar')->store('customers');
            $customer->avatar = $image_path;
        }

        if (!$customer->save()) {
            return redirect() - back()->with('error', 'Could not update this customer.');
        } else
            return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if ($customer->avatar) {
            Storage::delete($customer->avatar);
        }
        $customer->delete();
        return response()->json(['success' => true]);
    }
}
