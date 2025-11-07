document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    if (calendarEl) {

        var isMobile = window.innerWidth < 768;
        
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: isMobile ? 'timeGridDay' : 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: isMobile ? 'timeGridDay,listWeek' : 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: 'get_events.php',
            locale: 'pt-br',
            height: isMobile ? 500 : 650,
            eventColor: '#3788d8'
        });

        calendar.render();

        window.onresize = function() {
            calendar.updateSize();
        };
    }
});