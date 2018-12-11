/**
 * Created by mstoc on 24.10.2016.
 */

var tid;
var action = "read-student";

function readLivelessons(){
    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {action: "read-livelessons", p: "student", id: user.id, instrument: user.instrument}
    }).done(function (result) {
        console.log(result);
        res = $.parseJSON(result);

        $("#details").html();
        $("#details").html('Verfügbare Stunden: noch ' + result.replace('"', '').replace('"', ''));
    });
}


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
        selectable: false,
        selectHelper: true,
        allDaySlot: false,
        contentHeight: 600,
        scrollTime: "10:00:00",
        timeFormat: 'H:mm',
        slotLabelFormat: 'H:mm',
        slotDuration: '00:30:00',
        eventClick: function (calEvent, jsEvent, view) {
            if(calEvent.className.indexOf("blocked") > 0){
                if(calEvent.className.indexOf("blocked_" + user.id) > 0){
                    var deleteConfirm = window.confirm("Möchtest du die Buchung rückgängig machen?");
                    if(deleteConfirm){
                        prepareForDatabase(calEvent._start._d, calEvent._end._d, jsEvent, "delete-slot", calEvent._id);
                        setTimeout(function(){
                            if(typeof tid === "undefined"){
                                prepareForDatabase(calEvent._start._d, calEvent._end._d, jsEvent, action);
                            }else{
                                prepareForDatabase(calEvent._start._d, calEvent._end._d, jsEvent, action, tid);
                            }
                            readLivelessons();
                        }, 500);
                    }
                }else{
                    writeFlashmessage("Der Termin ist bereits gebucht, bitte wähle einen anderen.");
                }
            } else
            {
                var confirm = window.confirm("Möchtest du die Stunde wirklich buchen ?");
                if(confirm){
                    prepareForDatabase(calEvent._start._d, calEvent._end._d, jsEvent, "book-slot", calEvent._id);
                    setTimeout(function(){
                        if(typeof tid === "undefined"){
                            prepareForDatabase(calEvent._start._d, calEvent._end._d, jsEvent, action);
                        }else{
                            prepareForDatabase(calEvent._start._d, calEvent._end._d, jsEvent, action, tid);
                        }
                        readLivelessons();
                    }, 500);
                }
            }

        }


    });

    readLivelessons();

    /**
     * Get Calendar Data while the Calendar initializes
     */
    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {action: action, p: "calendar-view", id: user.id, instrument: user.instrument},
        beforeSend: function(){
            writeFlashmessage("Kalendertermine werden geladen.");
        }
    }).done(function (result) {
        writeFlashmessage("Kalendertermine erfolgreich geladen.");
        fetchEvents(result);
    });



});
