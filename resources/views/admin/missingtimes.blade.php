@extends('layouts.admin')
@section('content')
<style>
    .myTable {
        max-width: 19%;
    }
</style>
<center>
<div class="myTable">
    <table  class="table table-striped">
        <tr>
            <th>User</th>
            <th>Shift</th>
            <th>ID</th>
        </tr>    
        @foreach ($missingtimes as $missingtime)
            <tr>
                <th>{{$missingtime->user->name}}</th>
                <th>{{$missingtime->shift_start}}</th>
                <th><a href="{{route("admin.edit_user_calendar", $missingtime->id)}}">{{$missingtime->id}}</a></th>
            </tr>
        @endforeach        
    </table>
</div>
</center>

@endsection