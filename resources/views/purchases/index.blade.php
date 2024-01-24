@extends('layouts.admin')

@section('title','Purchase list')

@section('content-header','Purchase list')

@section('content-actions')
<a href="{{route('purchaseCart.index')}}" class="btn btn-primary float-sm-right ">New Order</a>
@endsection



@section('content')
<div class="card">
    <div class="car-body">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <form action="{{route('purchases.index')}}" method="GET">
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
                    <th>Provider Name</th>
                    <th class="text-right">Total</th>
                    <th class="text-right">Payement</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">To pay</th>
                    <th class="text-right">Created at</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $purchase)
                <tr>
                    <td>{{$purchase->id}}</td>
                    <td>{{$purchase->getProviderName()}}</td>
                    <td class="text-right">{{$purchase->formattedAmount()}} {{-- {{ config('settings.currency_symbol')}} --}}</td>
                    <td class="text-right">{{$purchase->formattedAmountPayement()}}{{-- {{ config('settings.currency_symbol')}} --}}</td>




                    <td class="text-center">@if ($purchase->getReceivedAmount()<=0) <span class="badge badge-danger">Not paid</span>

                            @else
                            @if ($purchase->getReceivedAmount()<$purchase->getAmount())
                                <span class="right badge badge-warning">Partial</span>

                                @else
                                <span class="right badge badge-info">Total</span>
                                @endif
                                @endif</td>
                    <td class="text-right">{{number_format($purchase->getAmount()-$purchase->getReceivedAmount(),2) }}</td>
                    <td class="text-right">{{$purchase->created_at}}</td>
                    <td>{{-- <a href="{{route('purchases.show',$purchase)}}" class="btn btn-primary">
                            <i class="fa-solid fa-eye"></i>
                        </a> --}}
                        <button class="btn btn-danger btn-delete" data-url="{{route('purchases.destroy',$purchase)}}">
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
                    <th class="text-right">{{number_format($totalGeneral,2) }}</th>
                    <th class="text-right">{{number_format($totalPayementGeneral,2) }}</th>
                    <th></th>
                    <th class="text-right">{{number_format($totalGeneral-$totalPayementGeneral,2) }}</th>
                    <th></th>

                </tr>
            </tfooter>
        </table>
        {{$purchases->render()}}
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