@extends('layouts.app')
@section('content')
    <table>
        <tr>
            <th>Video ID</th>
            <th>Comment</th>
        </tr>
        @foreach($comments as $comment)
        <tr>
            <td>{{$comment["snippet"]["videoId"]}}</td>
            <td>{{$comment["snippet"]["topLevelComment"]["snippet"]["textOriginal"]}}</td>
        </tr>
        @endforeach
    </table>
@endsection