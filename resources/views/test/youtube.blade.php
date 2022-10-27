@extends('layouts.app')
@section('content')

@foreach($commentThreads as $comments => $key)
    {{$key}}
@endforeach

@endsection