@extends('layouts.admin')
@section('content')

<table border="1">
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

@endsection