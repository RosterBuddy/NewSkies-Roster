@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <th>Start Time</th>
                        <th>Finish Time</th>
                        <th><a href="{{route('timing.create')}}">Create Time</a></th>
                    </tr>    
                    @foreach($timings as $timing)
                    <tr>
                        <th style="text-align:center">{{$timing->name}}</th>
                        <th style="text-align:center">{{\Carbon\Carbon::createFromFormat('H:i:s', $timing->shift_start)->format('H:i')}}</th>
                        <th style="text-align:center">{{\Carbon\Carbon::createFromFormat('H:i:s', $timing->shift_end)->format('H:i')}}</th>
                        <th style="text-align:center"><a href="{{route('timing.edit', $timing->id)}}">Edit Timing</a></th>
                    </tr>
                    @endforeach
            </table>
        </div>
    </div>
</div>
@endsection