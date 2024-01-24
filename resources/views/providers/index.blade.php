@extends('layouts.admin')

@section('title','Provider list')

@section('content-header','Provider list')

@section('content-actions')
<a href="{{route('providers.create')}}" class="btn btn-primary float-sm-right ">Add provider</a>
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
                @foreach ($providers as $provider)
                <tr>
                    <td><img src="{{Storage::url($provider->avatar)}}" alt="" width="50px"></td>

                    <td>{{$provider->id}}</td>
                    <td>{{$provider->first_name}}</td>

                    <td>{{$provider->last_name}}</td>
                    <td>{{$provider->email}}</td>
                    <td>{{$provider->phone}}</td>
                    <td>{{$provider->address}}</td>
                    {{-- <td><span class="right badge badge-{{$provider->status===true?'success':'danger'}}">{{$provider->status===true?'Active':'Unactive'}}</span> </td>
                    --}}
                    <td>{{$provider->created_at}}</td>
                    <td>{{$provider->updated_at}}</td>
                    <td><a href="{{route('providers.edit',$provider)}}" class="btn btn-primary">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="{{route('providers.show',$provider)}}" class="btn btn-info">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <button class="btn btn-danger btn-delete" data-url="{{route('providers.destroy',$provider)}}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                    {{-- <td><a href="{{route('providers.destroy',$provider)}}"><button>Delete</button></a></td> --}}
                </tr>
                @endforeach

            </tbody>
        </table>
        {{$providers->render()}}
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