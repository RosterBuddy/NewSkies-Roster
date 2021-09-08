@extends('layouts.admin')
@section('content')

<form action="{{ route('admin.update_user_calendar', $roster->id) }}" method="post">
    @csrf
    @method('PATCH')
    Agent Name: <input type="text" disabled value="{{$roster->user->name}}">
    <br />
    


    <br /><br />
    Description:
    <br />
    <textarea name="description"></textarea>
    <br /><br />
    Shift Start time:
    <br />
    <input type="datetime-local" value="{{$starttime}}" name="shift_start" class="date" />
    <br /><br />
    Shift End time:
    <br />
    <input type="datetime-local" value="{{$endtime}}" name="shift_end" class="date" />
    <br /><br />
    <input type="submit" value="Save" />
  </form>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
@endsection 
