/**
 * Created by dev on 16.11.16.
 */

function showForm(elem, e) {
    if (!$(elem).attr("disabled")) {
        if ($(".selected .count .overviewData").val() === "false") {
            alert("Bitte wähle die Stundenanzahl aus.");
        } else {
            $(".form").fadeIn(500);
            $('html, body').animate({
                scrollTop: $(".form").offset().top
            }, 1000);
        }
    }else{
        alert("Bitte wähle einen Dozenten.");
    }
    return false;
}

$("#submit").click(function (e) {
    if(!$("#agb").is(":checked")){
        alert("Bitte bestätige die Datenschutz- und Nutzungsbedingungen");
        e.preventDefault();
    }
});


$(document).ready(function () {

    $("#filterLecturer").change(function () {
        $(".advancedPackage").fadeOut();
        $("." + $(this).val()).fadeIn();
    });

    $("label[for=no], #no").click(function () {
        $(".friendsinput").fadeOut(500);
    });

    $("label[for=yes], #yes").click(function () {
        $(".friendsinput").fadeIn(500);
    });

    $(".advancedPackage").click(function () {
        // Reset
        $(".next").removeAttr("disabled");
        $("input.hidden_id").remove();
        $(".advancedPackage").find("ul").removeClass("selected");
        $("li.count").find("select").attr("name", "");
        $("li.title").css("background-color", "#333");

        $(this).find("ul").addClass("selected");
        $(this).find("li.title").css("background-color", "#cc1212");
        var id = $(this).attr("data-id");
        $(this).find("ul").find("li.count").append('<input type="hidden" form="coupon" class="hidden_id" name="coupon[packageId]" value="' + id + '">');
        $(this).find("ul").find("li.count").find("select").attr("name", "coupon[lessonCount]");

    });

})