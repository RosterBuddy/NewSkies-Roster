@extends('layouts.app')
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

@if(Auth::user()->isAdmin)
    <a style="margin-left:26.4%" class="btn btn-primary" href="{{route('admin.index')}}" role="button">Create New Schedule</a>
@endif

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
                    @if($roster->description == "work" || $roster->description == null && $roster->annual_leave != 1)
                        {
                            title : '{{$roster->user->name}}',
                            @if($roster->user->isAdmin == 1 && $roster->user->team_id == 2)
                                color : '{{$tlcoms}}',
                            @elseif($roster->user->isAdmin == 1 && $roster->user->team_id == 3)
                                color : '{{$tldisrupt}}',
                            @elseif($roster->user->isAdmin == 1 && $roster->user->team_id == 4)
                                color : '{{$tlsystem}}',
                            @endif
                                @if($roster->user->team_id == 1 && $roster->user->isAdmin != 1)
                                    color : '{{$unacc}}',
                                @elseif($roster->user->team_id == 2 && $roster->user->isAdmin != 1)
                                    color : '{{$coms}}',
                                @elseif($roster->user->team_id == 3 && $roster->user->isAdmin != 1)
                                    color : '{{$disrupt}}',
                                @elseif($roster->user->team_id == 4 && $roster->user->isAdmin != 1)
                                    color : '{{$system}}',
                                @endif
                            start : '{{ $roster->shift_start }}',
                            end : '{{ $roster->shift_end }}',
                        },
                    @endif
                @endforeach
            ],
        })
    });
</script>
@endsection