@extends('layouts.admin')


@section('title','Update Settings')
@section('content-header','Update Settings')


@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('settings.store')}}" method="POST">
            @csrf

            <div class="form-group">
                <label for="app_name">App name</label>
                <input type="text" class="form-control @error('app_name') is-invalid @enderror" placeholder="app_name" name="app_name" value="{{ old('app_name',config('settings.app_name')) }}" required autocomplete="app_name" autofocus>

            </div>

            @error('app_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


            <div class="form-group">
                <label for="app_description">App Description</label>
                <input type="text" class="form-control @error('app_description') is-invalid @enderror" placeholder="App Description" name="app_description" value="{{ old('app_description',config('settings.app_description')) }}" required autocomplete="app_description" autofocus>

            </div>

            @error('app_description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


            <div class="form-group">
                <label for="currency_symbol">Currency</label>
                <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" placeholder="currency_symbol" name="currency_symbol" value="{{ old('currency_symbol',config('settings.currency_symbol')) }}" required autocomplete="currency_symbol" autofocus>

            </div>

            @error('currency_symbol')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
</div>
@endsection