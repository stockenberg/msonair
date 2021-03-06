/**
 * Created by mstoc on 24.10.2016.
 */

var start_var;
var end_var;


$(document).ready(function () {
    /**
     * Initialize Calendar
     * @type {any}
     */

    calendar.fullCalendar({
        lang: 'DE',
        timezone: 'local',
        header: {
            right: 'prev,today,next',
            center: 'month,agendaWeek,agendaDay,listWeek'
        },
        weekNumbers: true,
        defaultView: 'agendaWeek',
        selectable: true,
        selectHelper: true,
        allDaySlot: false,
        contentHeight: 600,
        scrollTime: "10:00:00",
        timeFormat: 'H:mm',
        slotLabelFormat: 'H:mm',
        slotDuration: '00:30:00',
        select: function (start, end, jsevent) {
            for (timestamp_start = moment(start); timestamp_start < moment(end); timestamp_start) {
                start_var = timestamp_start.format("YYYY-MM-DD HH:mm");
                end_var = timestamp_start.add(0.5, "hours").format("YYYY-MM-DD HH:mm");
                prepareForDatabase(start_var, end_var, jsevent, "create");
            }
        },
        eventClick: function (calEvent, jsEvent, view) {
            if (calEvent.className.indexOf("blocked") > 0) {
                writeFlashmessage("Der Termin wurde von einem Schüler geblockt und kann nicht gelöscht werden.");
            } else {
                prepareForDatabase(calEvent._start._d, calEvent._end._d, jsEvent, "delete");

            }
        }


    });

    $("button.filter").click(function () {
        var instrument = this.classList[2];
        $.ajax({
            method: "POST",
            url: "../src/ajax/AjaxHandler.php",
            data: {action: "read", p: "manage-calendar", instrument: instrument}
        }).done(function (result) {
            fetchEvents(result);
        });
    });

    /**
     * Get Calendar Data while the Calendar initializes
     */
    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {action: "read", p: "manage-calendar"},
        beforeSend: function () {
            writeFlashmessage("Kalendertermine werden geladen.");
        }
    }).done(function (result) {
        writeFlashmessage("Kalendertermine erfolgreich geladen.");
        fetchEvents(result);
    });

});
