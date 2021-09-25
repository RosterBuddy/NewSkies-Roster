@extends('layouts.admin')
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
                    View Agents Profile
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <th>View Agent Profile</th>
                    </tr>    
                    @foreach ($users as $user)
                        <tr>
                            <th>{{$user->name}}</th>
                            <th><a href={{ route('admin.view_user_profile',$user->id)}}">View Profile</a></th>
                        </tr>
                    @endforeach        
                </table>
            </div>
        </div>
    </div>
</div>


@endsection


