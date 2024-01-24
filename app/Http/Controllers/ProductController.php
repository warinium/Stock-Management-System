<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $products = new Product();
        if ($request->search) {
            $products = $products->where('name', 'like', "%{$request->search}%");
        }

        $products = $products->latest()->orderBy('name', 'asc')->paginate(50);

        if (request()->wantsJson())
            /* dd($products); */
            return ProductResource::collection($products);

        return view('products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {

        $image_file_path = '';
        if ($request->hasFile('image')) {
            $image_file_path = $request->file('image')->store('products');
        }
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image_file_path,
            'barcode' => $request->barcode,
            'price' => $request->price,
            'purchase_price' => $request->purchase_price,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'name' => $request->name,
        ]);


        if (!$product) {
            return redirect()->back()->width('error', 'sorry there was a problem creating the product');
        } else {
            return redirect()->route('products.index')->with('success', 'product created successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        //dd($request->status);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->purchase_price = $request->purchase_price;
        $product->quantity = $request->quantity;
        $product->status = $request->status;

        if ($request->has('image')) {
            if ($product->image) {
                Storage::delete($product->image);
            }
            $image_path = $request->file('image')->store('products');
            $product->image = $image_path;
        }

        if (!$product->save()) {
            return redirect() - back()->with('error', 'Could not update this product.');
        } else
            return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete($product->image);
        }
        $product->delete();
        return response()->json(['success' => true]);
    }
}
