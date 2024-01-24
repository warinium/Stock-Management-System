<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderStoreRequest;
use App\Http\Requests\ProviderUpdateRequest;
use App\Models\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = Provider::latest()->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->paginate(10);


        if (request()->wantsJson()) {
            return response(Provider::all());
        }
        return view('providers.index')->with('providers', $providers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProviderStoreRequest $request)
    {

        $image_file_path = '';
        if ($request->hasFile('avatar')) {
            $image_file_path = $request->file('avatar')->store('providers');
        }
        $provider = Provider::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'avatar' => $image_file_path,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_id' => $request->user()->id,

        ]);


        if (!$provider) {
            return redirect()->back()->width('error', 'sorry there was a problem creating the provider');
        } else {
            return redirect()->route('providers.index')->with('success', 'Provider created successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $provider)
    {
        return view('providers.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {

        return view('providers.edit')->with('provider', $provider);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProviderUpdateRequest $request, Provider $provider)
    {

        $provider->first_name = $request->first_name;
        $provider->last_name = $request->last_name;
        $provider->phone = $request->phone;
        $provider->address = $request->address;
        $provider->email = $request->email;

        if ($request->has('avatar')) {
            if ($provider->avatar) {
                Storage::delete($provider->avatar);
            }
            $image_path = $request->file('avatar')->store('providers');
            $provider->avatar = $image_path;
        }

        if (!$provider->save()) {
            return redirect() - back()->with('error', 'Could not update this provider.');
        } else
            return redirect()->route('providers.index')->with('success', 'Provider updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        if ($provider->avatar) {
            Storage::delete($provider->avatar);
        }
        $provider->delete();
        return response()->json(['success' => true]);
    }
}
