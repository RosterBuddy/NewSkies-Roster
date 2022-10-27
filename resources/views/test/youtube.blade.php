@extends('layouts.app')
@section('content')

@foreach($comments as $comment)
    {{$comment}}
@endforeach


@endsection