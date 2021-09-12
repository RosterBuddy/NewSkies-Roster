@extends('layouts.admin')
@section('content')

<center>
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
            <th><a href="{{ route('admin.show_user_calendar',$user->id)}}">Show Roster</a></th>
        </tr>
        @endforeach
    </table>
</center>

@endsection