@extends('layouts.admin')

@section('title', 'Edit customer')

@section('content-header', 'Edit customer')

@section('content')



<div class="card">
    <div class="card-body">
        <form action="{{route('customers.update',$customer)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="form-group">
                <label for="first_name">first_name</label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="first_name" name="first_name" value="{{ old('first_name',$customer->first_name) }}" required autocomplete="first_name" autofocus>

            </div>

            @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


            <div class="form-group">
                <label for="last_name">last_name</label>
                <textarea class="form-control @error('last_name') is-invalid @enderror" placeholder="last_name" name="last_name">{{ old('last_name',$customer->last_name) }}
            </textarea>

            </div>

            @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror



            <div class="form-group">
                <label for="phone">phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="phone" name="phone" value="{{ old('phone',$customer->phone) }}" />


            </div>

            @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror






            <div class="form-group">
                <label for="email">email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="email" name="email" value="{{ old('email',$customer->email) }}" />

            </div>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror





            <div class="form-group">
                <label for="address">address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="address" name="address" value="{{ old('address',$customer->address) }}" />

            </div>

            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror



            <div class="form-group">
                <label for="avatar">avatar</label>
                <div class="custom-file">

                    <label class="custom-file-label" for="avatar">avatar</label>
                    <input type="file" class="custom-file-input" @error('avatar') is-invalid @enderror" placeholder="avatar" name="avatar" />


                </div>
            </div>

            @error('avatar')
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