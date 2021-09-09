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

<div id='calendar'></div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>

<script>
    $(document).ready(function() {
        var schedule = [{
                duration: 4,
                title: 'work',
                color: 'red'
            }, {
                duration: 4,
                title: 'off',
                color: 'blue'
            }, ];

            // define the range of events to generate
            var startDay = moment("2021-09-20");
            var endDay = moment("2021-09-27");

            // generate the events
            var events = [];
            // we loop from the start until we have passed the end day
            // the way the code is defined, it will always complete a schedule segment
            for (var s = 0, day = startDay; day.isBefore(endDay);) {
            // loop for each day of a schedule segment
            for (var i = 0; i < schedule[s].duration; i++) {
            
            
            // add the event with the current properties
            events.push({
                title: schedule[s].title,
                color: schedule[s].color,
            // we have to clone because the add() call below mutates the date
            start: day.clone(),
            
              });
              // go to the next day
              day = day.add(1, 'day');
            }

            // go to the next schedule segment
            s = (s + 1) % schedule.length;
            }

            
            for(let i = 0; i < events.length; i++){
                datewitnotime = events[i].start._d.toISOString()
                var date = moment(datewitnotime).format('YYYY/MM/DD HH:mm')
                title = events[i].title

                var givemedate = title + " " + date;
                $(".save-data").click(function(err, event){
                    let _token   = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "test/upload/",
                        type:"POST",
                        data:{
                            description:title,
                            shift_start:date,
                            shift_end:date,
                            _token: _token
                        },
                    });
                });
            }
            

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
            events: events  
        })
    });
</script>

<button class="btn btn-success save-data">Save</button>


@endsection