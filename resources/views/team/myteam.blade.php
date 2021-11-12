@extends('layouts.app')
@section('content')
<style>
    .myTable {
        max-width: 19%;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                    Your Team: {{$myteam->team_name}}
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <th>View Roster</th>
                    </tr>    
                    @foreach ($users as $user)
                        @if ($user->team_id == $myteam->id && $user->isTerminated != 1)
                            <tr>
                                <th>{{$user->name}}</th>
                                <th><a href={{ route('profile.show',$user->id)}}>View Profile</a></th>
                            </tr>
                        @endif
                    @endforeach        
                </table>
            </div>
        </div>
    </div>
</div>


@endsection


