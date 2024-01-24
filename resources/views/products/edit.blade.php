@extends('layouts.admin')

@section('title', 'Edit product')

@section('content-header', 'Edit product')

@section('content')



<div class="card">
    <div class="card-body">
        <form action="{{route('products.update',$product)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="name" name="name" value="{{ old('name',$product->name) }}" required autocomplete="name" autofocus>

            </div>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" placeholder="description" name="description">{{ old('description',$product->description) }}
            </textarea>

            </div>

            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror



            <div class="form-group">
                <label for="barcode">Barcode</label>
                <input type="text" class="form-control @error('barcode') is-invalid @enderror" placeholder="barcode" name="barcode" value="{{ old('barcode',$product->barcode) }}" />


            </div>

            @error('barcode')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror




            <div class="form-group">
                <label for="image">Image</label>
                <div class="custom-file">

                    <label class="custom-file-label" for="image">Image</label>
                    <input type="file" class="custom-file-input" @error('image') is-invalid @enderror" placeholder="image" name="image" />


                </div>
            </div>

            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror




            <div class="form-group">
                <label for="purchase_price">Purchase price</label>
                <input type="text" class="form-control @error('purchase_price') is-invalid @enderror" placeholder="purchase_price" name="purchase_price" value="{{ old('purchase_price',$product->purchase_price) }}" />

            </div>

            @error('purchase_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror




            <div class="form-group">
                <label for="price">Sell Price</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" placeholder="price" name="price" value="{{ old('price',$product->price) }}" />

            </div>

            @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror





            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="text" class="form-control @error('quantity') is-invalid @enderror" placeholder="quantity" name="quantity" value="{{ old('quantity',$product->quantity) }}" />

            </div>

            @error('quantity')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" placeholder="status" name="status">
                    <option value=1 {{old('status',$product->status)===true? 'selected' :''}}>Active</option>
                    <option value=0 {{old('status',$product->status)===false? 'selected' :''}}>Inactive</option>
                </select>

            </div>

            @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


            <button class="btn btn-primary" type="submit">Update</button>
        </form>

    </div>

</div>


@endsection

@section('js')

<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script>
    window.onload=function () {
      bsCustomFileInput.init();
    };
</script>

@endsection