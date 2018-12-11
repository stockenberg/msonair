/**
 * Created by mstoc on 05.11.2016.
 */

/**
 * Find Calendar
 */
var calendar = $('#cal') || "";

/**
 * Instanciate important variables
 * @param opts
 * @constructor
 */
function Main(opts){
    this.id = typeof opts.duuuude === "undefined" ? "" : opts.duuuude;
    this.instrument = typeof opts.sweeeeet === "undefined" ? "" : opts.sweeeeet;
    this.flashContainer = document.getElementById("flashMessage");
}

/**
 * Check if Div#flashmessage is empty - if not - show it for n seconds
 */
var timeout = 2000;
function checkFlashMessages(){
    if($(user.flashContainer).html() != ""){
        timeout += 2000;
        $(user.flashContainer).fadeIn();
        setTimeout(function(){
            $(user.flashContainer).fadeOut(function(){
                $(user.flashContainer).empty();
            });
        }, timeout)
    }
}

/**
 * Write Flash Messages
 * @param text
 */
function writeFlashmessage(text){
    $(user.flashContainer).html("<p>" + text + "</p>");
    checkFlashMessages();
}

/**
 * Fetch database result and prepare calendar events
 * @param result json_encoded database values
 */
function fetchEvents(result) {
    console.log(result);
    result = $.parseJSON(result);

    if(typeof result.flash === "string"){
        writeFlashmessage(result.flash);
    }

    calendar.fullCalendar("removeEvents");
    calendar.fullCalendar('addEventSource', result.success);
    calendar.fullCalendar('rerenderEvents');
}

/**
 * Prepare Eventdata to be submitted to Database
 * @param start Time where the Event starts
 * @param end Time where the Event ends
 * @param jsevent not know -.-
 * @param action decides which action will be executed delete, create, read
 * @param entry_id id of calendar entry
 * @param teacher_id id of calendar entry
 */
function prepareForDatabase(start, end, jsevent, action, entry_id) {
    _start = moment(start).format("YYYY-MM-DD HH:mm");
    _end = moment(end).format("YYYY-MM-DD HH:mm");

    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {action: action, p: "manage-calendar", start: _start, end: _end, id: user.id, instrument: user.instrument, entry_id: entry_id}
    }).done(function (result) {
        setTimeout(function() {
            fetchEvents(result)
        }, 100)
    });
}

function prepareForDatabaseArrayData(data, jsevent, action, entry_id) {

    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {action: action, p: "manage-calendar", data: data, id: user.id, instrument: user.instrument, entry_id: entry_id}
    }).done(function (result) {
        setTimeout(function() {
            fetchEvents(result)
        }, 100)
    });
}

$(document).ready(function(){
    checkFlashMessages();
});
