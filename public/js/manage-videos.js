var spinner = "<img style='text-align: center' src='img/rolling.gif' height='16px' width='16px'/>";

/**
 * Global get Function for Asynchronous requests
 * @private
 * @page
 *
 */

function unlock(element) {

    var userid = element.getAttribute("data-userid");
    var videoid = element.getAttribute("data-videoid");
    var unlocked = element.getAttribute("data-unlocked");
    var data;

    data = {user_id: userid, video_id: videoid, p: "manage-videos"};

    if (unlocked == "TRUE") {
        data.action = "delete";
        unlocked = "FALSE";
    } else {
        data.action = "create";
        unlocked = "TRUE";
    }

    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: data
    }).done(function (result) {
        console.log(result);
        element.setAttribute("data-unlocked", unlocked)
    });
}

$(document).ready(function () {


});
