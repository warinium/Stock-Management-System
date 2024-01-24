@extends('layouts.admin')

@section('title', 'Create product')

@section('content-header', 'Create product')

@section('content')



<div class="card">
    <div class="card-body">
        <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
            @csrf



            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ old('name') }}" {{-- required --}} autocomplete="name" autofocus>

            </div>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Description" name="description">
            </textarea>

            </div>

            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror



            <div class="form-group">
                <label for="barcode">Barcode</label>
                <input type="text" class="form-control @error('barcode') is-invalid @enderror" placeholder="Barcode" name="barcode" />


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
                    <input type="file" class="custom-file-input" @error('image') is-invalid @enderror" placeholder="Image" name="image" />


                </div>
            </div>

            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror




            <div class="form-group">
                <label for="purchase_price">Purchase price</label>
                <input type="text" class="form-control @error('purchase_price') is-invalid @enderror" placeholder="Price" name="purchase_price" />

            </div>

            @error('purchase_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror



            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" placeholder="Price" name="price" />

            </div>

            @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="text" class="form-control @error('quantity') is-invalid @enderror" placeholder="Quantity" name="quantity" />

            </div>

            @error('quantity')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" placeholder="Status" name="status">
                    <option value="1" {{old('status')===1? 'selected' :''}}>Active</option>
                    <option value="0" {{old('status')===0? 'selected' :''}}>Inactive</option>
                </select>

            </div>

            @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


            <button class="btn btn-primary" type="submit">Create</button>
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