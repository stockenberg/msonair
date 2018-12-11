/**
 * Created by mstoc on 22.10.2016.
 */

var spinner = "<img src='img/rolling.gif' height='16px' width='16px'/>";

/**
 * Global get Function for Asynchronous requests
 * @private
 * @page
 */
function __get(element, page){
    var resultElem = $("#result");
    var identifier = "global";
    var id = $(element).find("option:selected").attr("value");
    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {p: identifier, user_id: id, action: page},
        beforeSend: function(){
            resultElem.html(spinner);
        }
    }).done(function (result) {
        console.log(result)
        resultElem.html(result);
    });

}

$(document).ready(function(){


});