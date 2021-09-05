<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>

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
<div id='calendar'></div>


<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            defaultView: 'agendaDay',
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
                    {
                        title : '{{$roster->user->name}}',
                        backgroundColor : 'rgb(255,0,0)',
                        eventBorderColor : 'rgb(255,0,0)',
                        start : '{{ $roster->shift_start }}',
                        end : '{{ $roster->shift_end }}',
                        url : '{{ route('roster.edit', $roster->id) }}'
                    },
                @endforeach
            ],
        })
    });
</script>