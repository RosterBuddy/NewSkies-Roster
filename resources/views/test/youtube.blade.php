@extends('layouts.app')
@section('content')

{{$commentThreads}}

@foreach($threads as $comments)
    {{$comments}}
@endforeach

@endsection