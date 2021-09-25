@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <table class="table table-striped">
                    <tr>
                        <th>Team Name</th>
                        <th>No. Members</th>
                        <th>View Team Members</th>
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
    </div>
</div>
@endsection


