@if (Session::has('error') && Session::get('error')!='')
<div class="alert alert-danger">
    {{Session::get('error')}}
</div>

@endif