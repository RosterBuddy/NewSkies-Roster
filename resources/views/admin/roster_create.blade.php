@extends('layouts.app')

@section('content')
<form action="{{ route('admin.store') }}" method="post">
    {{ csrf_field() }}
    Select Agent Name:
    <br />
    <select name="user_id">
      @foreach ($users as $user)
        <option name="user_id" value="{{$user->id}}">{{$user->name}}</option>  
      @endforeach
    </select>    
    
    
    <br /><br />
    Description:
    <br />
    <textarea name="description"></textarea>
    <br /><br />
    Shift Start time:
    <br />
    <input type="datetime-local" name="shift_start" class="date" />
    <br /><br />
    Shift End time:
    <br />
    <input type="datetime-local" name="shift_end" class="date" />
    <br /><br />
    <input type="submit" value="Save" />
  </form>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
@endsection