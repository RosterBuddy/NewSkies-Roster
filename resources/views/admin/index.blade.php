@extends('layouts.admin')
@section('content')
<style>
.center-screen {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;   
}

.menu-container{
    width:21%;
    /*border: 1px solid #000;*/
    padding-top: 10px;
}
.action-container{
    display:inline-block;
    margin-bottom: 5px;
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
    <div class="menu-container">
        <div class="button-container">
            <div style="margin-right: 6%;" class="action-container">
                <a  class="btn btn-primary btn-lg" href="{{route('admin.create')}}" role="button">Create Roster</a>
            </div>
            <div style="margin-right: 6%;" class="action-container">
                <a class="btn btn-primary btn-lg" href="{{route('admin.newuser')}}" role="button">Create User Profile</a>
            </div>
            <div style="margin-right: 6%; margin-top: 5%;" class="action-container">
                <a class="btn btn-primary btn-lg" href="{{route('admin.show_user')}}" role="button">Update Roster</a>
            </div>
            <div style="margin-right: 6%; margin-top: 5%;" class="action-container">
                <a class="btn btn-primary btn-lg" href="{{route('admin.select_user_profile')}}" role="button">Update User Profile</a>
            </div>
            <div style="margin-right: 6%; margin-top: 5%;" class="action-container">
                <a class="btn btn-primary btn-lg" href="#" role="button">Place Holder</a>
            </div>
            <div style="margin-right: 6%; margin-top: 5%;" class="action-container">
                <a class="btn btn-primary btn-lg" href="#" role="button">Place Holder</a>
            </div>
        </div>
    </div>
</div>

@endsection