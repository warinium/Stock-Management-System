@extends('layouts.admin')

@section('title', 'Create customer')

@section('content-header', 'Create customer')

@section('content')



<div class="card">
    <div class="card-body">
        <form action="{{route('customers.store')}}" method="post" enctype="multipart/form-data">
            @csrf



            <div class="form-group">
                <label for="first_name">First name</label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="First name" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus />

            </div>

            @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


            <div class="form-group">
                <label for="last_name">Last name</label>
                <input class="form-control @error('last_name') is-invalid @enderror" placeholder="Last name" name="last_name" />

            </div>

            @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror



            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" name="phone" />


            </div>

            @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror







            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" />

            </div>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="Address" name="address" />

            </div>

            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror



            <div class="form-group">
                <label for="avatar">Avatar</label>
                <div class="custom-file">

                    <label class="custom-file-label" for="avatar">Avatar</label>
                    <input type="file" class="custom-file-input" @error('avatar') is-invalid @enderror" placeholder="avatar" name="avatar" />


                </div>
            </div>

            @error('avatar')
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