@extends('layouts.admin')
@section('content')

<h1>Not Completed</h1>
<table border="1">
    <tr>
        <th>Team Name</th>
    </tr>
    
    @foreach ($teams as $team)
    <tr>
        <th>{{$team->team_name}}</th>
        <th><a href="#"></a></th>
    </tr>
    @endforeach
    
</table>

@endsection