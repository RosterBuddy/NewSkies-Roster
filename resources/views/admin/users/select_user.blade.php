@extends('layouts.admin')
@section('content')
<div class="container">
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">Active Users</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Roster</th>
                            </tr>
                            @foreach ($users as $user)
                                @if($user->isTerminated == 0)
                                <tr>
                                    <th>{{$user->name}}</th>
                                    <th>{{$user->email}}</th>
                                    <th><a href="{{ route('admin.view_user_profile',$user->id)}}">Edit User</a></th>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="card text-center">
                <div class="card-header">Terminated Users</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Roster</th>
                            </tr>
                            @foreach ($users as $user)
                                @if($user->isTerminated == 1)
                                <tr>
                                    <th>{{$user->name}}</th>
                                    <th>{{$user->email}}</th>
                                    <th><a href="{{ route('admin.view_user_profile',$user->id)}}">Edit User</a></th>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection