@extends('layouts.admin')
@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card text-center">
        <div class="card-header">
            Edit the {{$timing->name}} Times
        </div>
        <div class="card-body">
        <form action="{{ route('timing.update', $timing->id) }}" method="post">
            @csrf
            @method('PATCH')
            Shift Start Time:<input type="time" value="{{\Carbon\Carbon::createFromFormat('H:i:s', $timing->shift_start)->format('H:i')}}" name="shift_start" class="date" />
            <br>
            <br>Shift End Time:<input type="time" value="{{\Carbon\Carbon::createFromFormat('H:i:s', $timing->shift_end)->format('H:i')}}" name="shift_end" class="date" />
            <br>
            <br>
            Select User Type:
            <select name="user_type">
              <option value="Agent">Agent</option>
              <option value="Teamlead">Teamlead</option>
            </select>
            <br>
            <br>
            <input type="submit" value="Save"/>
        </form>
      </div>
    </div>
   </div>
  </div>
</div> 
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
@endsection 
