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
        <table  class="table table-striped">
            <tr>
                <th>Team Name</th>
                <th>No. Members</th>
                <th></th>
            </tr>    
            @foreach ($teams as $team)
            <tr>
                <th style="text-align:center">{{$team->team_name}}</th>
                <th style="text-align:center">@if($team->id == 1)
                        {{$unassigned}}
                    @elseif($team->id == 2)
                        {{$coms}}
                    @elseif($team->id == 3)
                        {{$disruptions}}
                    @elseif($team->id == 4)
                        {{$systems}}
                    @endif
                </th>
                <th style="text-align:center"><a href="{{route('teams.show', $team->id)}}">View Team</a></th>
            </tr>
        @endforeach        
    </table>
</div>
</center>
@endsection


