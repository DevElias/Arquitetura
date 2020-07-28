$(document).ready(function() {
    /* initialize the external events
            -----------------------------------------------------------------*/


    function initEvent() {
        $('#external-events .fc-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                color: $(this).css('background-color'),
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0 // original position after the drag
            });

        });
    }
    initEvent();

    /* initialize the calendar
    -----------------------------------------------------------------*/
    var newDate = new Date,
        date = newDate.getDate(),
        month = newDate.getMonth(),
        year = newDate.getFullYear();

    var url_atual = window.location.href;
    var res = url_atual.split("/");

    /* Busca Eventos para o calendario*/

    $('#calendar').fullCalendar({

        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        themeSystem: "bootstrap4",
        locale: 'pt-br',
        droppable: false,
        editable: false,
        eventLimit: false, // allow "more" link when too many events
        allDayDefault: true,

        events: '/listagem/financeiro/'+res[4],
    });








    jQuery(".js-form-add-event").on("submit", function(e) {
        e.preventDefault();

        var data = $('#newEvent').val();
        $('#newEvent').val('');
        $('#external-events').prepend('<li class="list-group-item bg-success fc-event">' + data + '</li>');

        initEvent();
    });

});
