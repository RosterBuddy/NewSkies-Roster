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
            <form action="{{ route('timing.store')}}" method="POST">
            @csrf
                Shift Name:<br>
                <input type="text" id="name">
                <br>
                <br>
                Start Time:<br>
                <input type="time" id="shift_start">
                <br>
                <br>
                Finish Time:<br>
                <input type="time" id="shift_end">
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