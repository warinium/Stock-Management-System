@extends('layouts.admin')

@section('content-header', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">

            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 class='float-right'>{{$purchases_count}}</h3>
                    <p>{{ ('Purchase count') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{route('purchases.index')}}" class="small-box-footer">{{ ('More') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner ">
                    <h3 class='float-right'>{{number_format($outcome, 2)}} {{config('settings.currency_symbol')}} </h3>
                    <p>{{ ('outcome') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('orders.index')}}" class="small-box-footer">{{ ('More') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 class='float-right'>{{number_format($outcome_today, 2)}} {{config('settings.currency_symbol')}} </h3>

                    <p>{{ ('Outcome today') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{route('orders.index')}}" class="small-box-footer">{{ ('More') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 class='float-right'>{{$providers_count}}</h3>

                    <p>{{ ('Providers count') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('providers.index') }}" class="small-box-footer">{{ ('More') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 class='float-right'>{{$orders_count}}</h3>
                    <p>{{ ('Orders count') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{route('orders.index')}}" class="small-box-footer">{{ ('More') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner ">
                    <h3 class='float-right'>{{number_format($income, 2)}} {{config('settings.currency_symbol')}} </h3>
                    <p>{{ ('Income') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('orders.index')}}" class="small-box-footer">{{ ('More') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 class='float-right'>{{number_format($income_today, 2)}} {{config('settings.currency_symbol')}} </h3>

                    <p>{{ ('Income today') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{route('orders.index')}}" class="small-box-footer">{{ ('More') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 class='float-right'>{{$customers_count}}</h3>

                    <p>{{ ('Customers count') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('customers.index') }}" class="small-box-footer">{{ ('More') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

    </div>
</div>
@endsection