@extends('layouts.admin')
@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card text-center">
        <div class="card-header">
          Create Single Shift
        </div>
        <div class="card-body">
          <form action="{{ route('admin.store') }}" method="post">
          {{ csrf_field() }}
            Select Agent Name:
            <br>
          <select name="user_id">
          @foreach ($users as $user)
            <option name="user_id" value="{{$user->id}}">{{$user->name}}</option>  
          @endforeach
          </select>    
            <br>
            <br>
            Description:
            <br>
          <textarea name="description"></textarea>
            <br>
            <br>
          Shift Start time:
            <br>
          <input type="datetime-local" name="shift_start" class="date" />
            <br>
            <br>
          Shift End time:
            <br>
          <input type="datetime-local" name="shift_end" class="date" />
            <br>
            <br>
            Day Type
            <br>
            <select name="day_off">
                <option value="0">None</option>
                <option value="1">A/L</option>
                <option value="2">B/H</option>
            </select>
            <br>
            <br>
          <button class="btn btn-primary" type="submit">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> 
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>

@endsection