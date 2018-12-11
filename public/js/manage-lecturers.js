/**
 * Created by mstoc on 26.10.2016.
 */
var spinner = "<img src='img/rolling.gif' height='16px' width='16px'/>";

/**
 * Load Edit Template
 * @param id
 */
function getEdit(id){
    var action = "edit-form";
    resultrow = $("tr." + id);
    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {action: action, id: id, p: "manage-lecturers"},
        beforeSend: function(){
            $(resultrow).after(spinner);
        }
    }).done(function (result) {
        $(resultrow).after(result);
        $("tbody").find("img").remove();
    });
}

/**
 * Change Data Event, if input gets another value the database entry will change
 * @param event
 * @param id
 */
function changeData(event, id){
    action = "update";
    label = $("label[for='"+event.id+"']");
    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {action: action, id: id, p: "manage-lecturers", value: event.value, column: event.id},
        beforeSend: function(){
            label.html(spinner);
        }
    }).done(function (result) {
        label.html(result);
        label.css("color", "green");
        $("tbody").find("img").remove();
    });
}

/**
 * Delete Lecturer by Click on button
 * @param id
 */
function delete_lecturer(id){
    var confirm = window.confirm("Willst du diesen Lehrer wirklich löschen ?");
    if(confirm){
        action = "delete";
        $.ajax({
            method: "POST",
            url: "../src/ajax/AjaxHandler.php",
            data: {action: action, id: id, p: "manage-lecturers"}
        }).done(function (result) {
            console.log(result);
            $("tr." + id).remove();
            $("body").find(".edit_" + id).remove();
        });
    }
}

$(document).ready(function(){

    /**
     * Close Edit container
     */
    $("body").on("click", ".close", function () {
        $(this).parent().parent().remove();
    })

});
