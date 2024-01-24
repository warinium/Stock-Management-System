@extends('layouts.admin')

@section('title','Order list')

@section('content-header','Order list')

@section('content-actions')
<a href="{{route('cart.index')}}" class="btn btn-primary float-sm-right ">Open POS</a>
@endsection

{{-- @section('css')
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.css')}}">
@endsection --}}

@section('content')
<div class="card">
    <div class="car-body">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <form action="{{route('orders.index')}}" method="GET">
                    <div class="row">
                        <div class="col-md-5"><input type="date" name="start_date" value="{{request('start_date')}}" class="form-control"></div>
                        <div class="col-md-5"><input type="date" name="end_date" value="{{request('end_date')}}" class="form-control"></div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary">Filter</button>

                        </div>
                    </div>
                </form>

            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Total</th>
                    <th>Payement</th>
                    <th>Status</th>
                    <th>To pay</th>
                    <th>Created at</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->getCustomerName()}}</td>
                    <td>{{$order->formattedAmount()}} {{-- {{ config('settings.currency_symbol')}} --}}</td>
                    <td>{{$order->formattedAmountPayement()}}{{-- {{ config('settings.currency_symbol')}} --}}</td>




                    <td>@if ($order->getReceivedAmount()<=0) <span class="right badge badge-danger">Not paid</span>

                            @else
                            @if ($order->getReceivedAmount()<$order->getAmount())
                                <span class="right badge badge-warning">Partial</span>

                                @else
                                <span class="right badge badge-info">Total</span>
                                @endif
                                @endif</td>
                    <td>{{number_format($order->getAmount()-$order->getReceivedAmount(),2) }}</td>
                    <td>{{$order->created_at}}</td>
                    <td>{{-- <a href="{{route('orders.show',$order)}}" class="btn btn-primary">
                            <i class="fa-solid fa-eye"></i>
                        </a> --}}
                        <button class="btn btn-danger btn-delete" data-url="{{route('orders.destroy',$order)}}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>

                @endforeach

            </tbody>
            <tfooter>
                <tr>
                    <th></th>
                    <th></th>
                    <th>{{number_format($totalGeneral,2) }}</th>
                    <th>{{number_format($totalPayementGeneral,2) }}</th>
                    <th></th>
                    <th>{{number_format($totalGeneral-$totalPayementGeneral,2) }}</th>
                    <th></th>

                </tr>
            </tfooter>
        </table>
        {{$orders->render()}}
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>

<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<script>
    $(document).ready(function(){
        $(document).on('click','.btn-delete',function(){
                $this=$(this);

            Swal.fire({
                title: "Confirmation",
                text: "Are you sûre ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.post($this.data('url'),{_method:'DELETE',_token:'{{csrf_token()}}'},function(res){
                        $this.closest('tr').fadeOut(500,function(){
                            $(this).remove();
                        })
                    })
                    /* Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                    }); */
                }
                });

            })
    })
</script>
@endsection