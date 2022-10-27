@extends('layouts.app')
@section('content')
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Video ID</th>
      <th scope="col">Comment</th>      
    </tr>
  </thead>
  <tbody>
    @foreach($comments as $comment)
        <tr>
            <td>{{$comment["snippet"]["videoId"]}}</td>
            <td>{{$comment["snippet"]["topLevelComment"]["snippet"]["textOriginal"]}}</td>
        </tr>
    @endforeach
  </tbody>
</table>
@endsection