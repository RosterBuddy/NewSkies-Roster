@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th>Roster</th>
                </tr>
                @foreach ($users as $user)
                <tr>
                    <th>{{$user->name}}</th>
                    <th>{{$user->email}}</th>
                    <th><a href="{{ route('admin.view_user_profile',$user->id)}}">Edit User</a></th>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection