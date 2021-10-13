@extends('layouts.admin')
@section('content')


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card text-center">
        <div class="card-header">
            Create A New Roster Time
         </div>
        <div class="card-body">
          <form action="{{ route('timing.store') }}" method="post">
            @csrf
            Name:<input type="text" name="shift_name">
            <br>
            <br>
            Shift Start Time:<input type="time" name="shift_start" class="date" />
            <br>
            <br>
            Shift End Time:<input type="time" name="shift_end" class="date" />
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
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
@endsection