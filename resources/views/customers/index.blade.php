@extends('layouts.admin')

@section('title','Customer list')

@section('content-header','Customer list')

@section('content-actions')
<a href="{{route('customers.create')}}" class="btn btn-primary float-sm-right ">Add customer</a>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.css')}}">
@endsection

@section('content')
<div class="card">
    <div class="car-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>ID</th>
                    <th>First name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td><img src="{{Storage::url($customer->avatar)}}" alt="" width="50px"></td>

                    <td>{{$customer->id}}</td>
                    <td>{{$customer->first_name}}</td>

                    <td>{{$customer->last_name}}</td>
                    <td>{{$customer->email}}</td>
                    <td>{{$customer->phone}}</td>
                    <td>{{$customer->address}}</td>
                    {{-- <td><span class="right badge badge-{{$customer->status===true?'success':'danger'}}">{{$customer->status===true?'Active':'Unactive'}}</span> </td>
                    --}}
                    <td>{{$customer->created_at}}</td>
                    <td>{{$customer->updated_at}}</td>
                    <td><a href="{{route('customers.edit',$customer)}}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="{{route('customers.show',$customer)}}" class="btn btn-info">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <button class="btn btn-danger btn-delete" data-url="{{route('customers.destroy',$customer)}}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                    {{-- <td><a href="{{route('customers.destroy',$customer)}}"><button>Delete</button></a></td> --}}
                </tr>
                @endforeach

            </tbody>
        </table>
        {{$customers->render()}}
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