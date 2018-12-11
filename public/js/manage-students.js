/**
 * Created by mstoc on 17.10.2016.
 */

var spinner = "<img src='img/rolling.gif' height='16px' width='16px'/>";

/**
 * called by onchange event on input elements, changes Userdata
 * @param event Event
 * @param id int
 */
function changeData(event, id){
    action = "changeData";
    label = $("label[for='"+event.id+"']");
    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {action: action, id: id, p: "manage-students", value: event.value, column: event.id},
        beforeSend: function(){
            label.html(spinner);
        }
    }).done(function (result) {
        label.html(result);
        label.css("color", "green");
    });
}

$(document).ready(function () {

    /**
     * Gets taken jQuery Object and starts a timeout for each click, after 10 seconds, controlls will fade out
     * @param param
     */
    function resetView(param) {
        setTimeout(function () {
            param.parent().find(".button").addClass("hidden");
            param.fadeToggle();
        }, 10000)
    }

    /**
     * Hide and Show Settings in Student-Section
     */
    $(".fa-gears").click(function () {
        $(this).fadeToggle(0);
        $(this).parent().find(".button").removeClass("hidden");
        resetView($(this));
    });

    /**
     * Need it for for-loop
     */
    var alphabet = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K",
                    "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V",
                    "W", "X", "Y", "Z", "Ä", "Ö", "Ü"];

    // TODO implement Ä-Ö-Ü names, acutally they'r buggy

    /**
     * Hide all Data if no user is in Database
     */
    for (i = 0; i <= alphabet.length; i++) {
        var elem = $("#" + alphabet[i]);
        if (elem.next("ul").children().length === 0) {
            $(elem).parent().fadeOut();
            $(".student-nav." + alphabet[i]).addClass("disabled");
        }
    }

    /**
     * Ajax Requests for "Alle Rechnungen", "Edit", "Save" and "Delete"
     */
    $(".users button").click(function () {
        var student_id = $(this).attr("data-student-id");
        var action = $(this).attr("data-action");
        var resultContainer = $("button[data-student-id='" + student_id + "']").parent();
        $.ajax({
            method: "GET",
            url: "../src/ajax/AjaxHandler.php",
            data: {action: action, id: student_id, p: "manage-students"},
            beforeSend: function(){
                resultContainer.find(".result").html(spinner);
            }
        }).done(function (result) {
            resultContainer.find(".result").remove();
            resultContainer.append("<li class='result'><span class='center close'>Close</span>" + result + "<span class='right close'>Close</span></li>");
        });

    });

    /**
     * click away the results
     */
    $("body").on("click", ".close", function () {
        $(this).parent().remove();
    })
});
