var spinner = "<img style='text-align: center' src='img/rolling.gif' height='16px' width='16px'/>";

/**
 * Global get Function for Asynchronous requests
 * @private
 * @page
 */


function unlock(element) {
    var userid = element.getAttribute("data-userid");
    var fileid = element.getAttribute("data-fileid");
    var unlocked = element.getAttribute("data-unlocked");
    var data;

    data = {user_id: userid, file_id: fileid, p: "manage-documents"};

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
