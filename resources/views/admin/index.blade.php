@extends('layouts.admin')
@section('content')
<style>
.center-screen {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;   
}

/*This is modifying the btn-primary colors but you could create your own .btn-something class as well*/
.btn-primary {
    color: #fff;
    background-color: #073590;
    border-color: #073590; /*set the color you want here*/
}

.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open>.dropdown-toggle.btn-primary {
    color: #fff;
    background-color: #f1c933;
    border-color: #f1c933; /*set the color you want here*/
}

</style>

<div class="center-screen">
    <a style="margin-right: 2%;" class="btn btn-primary btn-lg" href="{{route('admin.create')}}" role="button">Update Roster</a>
    <a style="margin-left: 2%;"  class="btn btn-primary btn-lg" href="#" role="button">Update User Profile</a>
</div>

@endsection