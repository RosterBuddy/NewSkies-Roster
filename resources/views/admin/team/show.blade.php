@extends('layouts.admin')
@section('content')
<style>
    .myTable {
        max-width: 19%;
    }
</style>
<center>
<div class="myTable">
    <h1>Not Completed</h1>
        <table class="table table-striped table-responsive">
            <tr>
                <th>Name</th>
                <th></th>
            </tr>    
            @foreach ($users as $user)
            <tr>
                <th>{{$user->name}}</th>
                <th><a href={{ route('admin.view_user_profile',$user->id)}}">View Profile</a></th>
            </tr>
            @endforeach        
        </table>
</div>       
</center> 
@endsection


