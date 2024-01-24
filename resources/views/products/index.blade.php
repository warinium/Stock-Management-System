@extends('layouts.admin')

@section('title','Product list')

@section('content-header','Product list')

@section('content-actions')
<a href="{{route('products.create')}}" class="btn btn-primary float-sm-right ">Create product</a>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.css')}}">
@endsection

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Barcode</th>
            <th>Purchase Price</th>
            <th>Sell Price</th>
            <th class="text-right">Initial Qty</th>
            <th class="text-right">Qty</th>
            <th>Status</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td class="align-middle">{{$product->id}}</td>
            <td>{{$product->name}}</td>
            <td><img src="{{$product->image==''?Storage::url('no_image.jpg'):Storage::url($product->image)}}" alt="" width="100px"></td>

            <td>{{$product->barcode}}</td>
            <td class="text-right">{{$product->purchase_price}}</td>
            <td class="text-right">{{$product->price}}</td>
            <td class="text-right">{{$product->quantity}}</td>
            <td class="text-right">{{$product->stock->quantity}}</td>
            <td><span class="right badge badge-{{$product->status===true?'success':'danger'}}">{{$product->status===true?'Active':'Unactive'}}</span> </td>
            <td>{{$product->created_at}}</td>
            <td>{{$product->updated_at}}</td>
            <td><a href="{{route('products.edit',$product)}}" class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>

                <button class="btn btn-danger btn-delete" data-url="{{route('products.destroy',$product)}}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
            {{-- <td><a href="{{route('products.destroy',$product)}}"><button>Delete</button></a></td> --}}
        </tr>
        @endforeach

    </tbody>
</table>
{{$products->render()}}
< </div>
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