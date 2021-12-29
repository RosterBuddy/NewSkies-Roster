@extends('layouts.admin')
@section('content')

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

<style>
html, body {
    margin: 0;
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
      font-size: 14px;
}

#calendar {
    max-width: 900px;
    margin: 40px auto;
}
#calendar a.fc-event {
    color: #fff; /* bootstrap default styles make it black. undo */
}
</style>

<div class="text-center">
    @if($count > 0)
        <p>There has been {{$count}} changes to {{$user->name}}s roster. </p>
        <p><a class="btn btn-info" role="button" href="{{route('email.lastedited', $id)}}">Click Here</a> to notify</p>
    @endif
    <div class="card-body">
        <form action="{{route('admin.delete_user_roster', $id)}}" method="post">
            @csrf
            @method('PATCH')
            <input type="submit" class="btn btn-success" value="Clear Roster"/>
        </form>
</div>
<div id='calendar'></div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>

<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            defaultView: 'month',
            minTime: '06:00:00', /* calendar start Timing */
            maxTime: '24:00:00',  /* calendar end Timing */
            timeFormat: 'H:mm', /* 24Hour Clock Format */
            allDaySlot: false,
            handleWindowResize: true,   
            height: $(window).height(),   

            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay',
            },

            events : [
                @foreach($rosters as $roster)
                    @if($roster->user_id == $id)
                        @if($roster->description != "off" && $roster->day_off == 0)
                            {
                                title : '{{$roster->user->name}}',
                                start : '{{ $roster->shift_start }}',
                                end : '{{ $roster->shift_end }}',
                                url : '{{route("admin.edit_user_calendar", $roster->id)}}',
                            },
                        @elseif($roster->day_off == 1)
                            {
                                title : 'A/L',
                                color : '#AAABBB',
                                start : '{{ $roster->shift_start }}',
                                end : '{{ $roster->shift_end }}',
                                url : '{{route("admin.edit_user_calendar", $roster->id)}}',
                            },
                        @elseif($roster->day_off == 2)
                            {
                                title : 'B/H',
                                color : '#AAABBB',
                                start : '{{ $roster->shift_start }}',
                                end : '{{ $roster->shift_end }}',
                                url : '{{route("admin.edit_user_calendar", $roster->id)}}',
                            },
                        @endif
                    @endif
                @endforeach
            ],
        })
    });
</script>
@endsection