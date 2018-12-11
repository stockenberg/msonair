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
    var calendar = $('#cal');
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
            var dates = [];

            for (timestamp_start = moment(start); timestamp_start < moment(end); timestamp_start) {
                start_var = timestamp_start.format("YYYY-MM-DD HH:mm");
                end_var = timestamp_start.add(1, "hours").format("YYYY-MM-DD HH:mm");

                dates.push({"start": start_var, "end": end_var});

            }

            prepareForDatabaseArrayData(dates, jsevent, "teacher-create");
        },
        eventClick: function (calEvent, jsEvent, view) {
            if (calEvent.className.indexOf("blocked") > 0) {
                writeFlashmessage("Der Termin wurde von einem Schüler gebucht und kann nicht gelöscht werden. Bitte kontaktiere die Verwaltung.");
            } else {
                prepareForDatabase(calEvent._start._d, calEvent._end._d, jsEvent, "teacher-delete")
            }
        }
    });


    /**
     * Get Calendar Data while the Calendar initializes
     */
    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {action: "teacher-read", p: "manage-calendar", id: user.id},
        beforeSend: function () {
            writeFlashmessage("Kalendertermine werden geladen.");
        }
    }).done(function (result) {
        writeFlashmessage("Kalendertermine erfolgreich geladen.");
        fetchEvents(result);
    });


});
