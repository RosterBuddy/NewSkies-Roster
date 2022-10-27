@extends('layouts.app')
@section('content')

@foreach($commentThreads as $comments)
    {{$comments}}
@endforeach

@endsection