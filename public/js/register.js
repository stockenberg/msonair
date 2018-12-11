/**
 * Created by workstation on 11/21/16.
 */
var spinner = "<img src='img/rolling.gif' height='16px' width='16px'/>";


function check(){
    value = $(".username_input").val();
    console.log(value);
    $.ajax({
        method: "POST",
        url: "../src/ajax/AjaxHandler.php",
        data: {action: "checkUsername", p: "register", value: value},
        beforeSend: function(){
            $(".username").html(spinner);
        }

    }).done(function (result) {
        $(".username").html(result);

    });
}

$("#submit").click(function (e) {
    if(!$("#widerruf").is(":checked")){
        alert("Bitte bestätige die Widerrufsbehlehrung");
        e.preventDefault();
    }
    if(!$("#agb").is(":checked")){
        alert("Bitte bestätige die AGBs");
        e.preventDefault();
    }
});

function removeRequire(elem){
    if($(elem).val() !== ""){
        $(".paymentbutton").html("Gutschein einlösen");
        $(".overviewPayment").removeAttr("required");
        $(".paymentform").fadeOut();
        $("#submit").val("Registrierung abschließen");
    }else{
        $(".paymentbutton").html("Bitte wähle deine Zahlungsweise");
        $(".paymentform").fadeIn();
        $(".overviewPayment").attr("required", "required");
        $("#submit").val("Kostenpflichtig bestellen.")
    }
}


$(".advancedPackage").click(function () {
    // Reset
    $("input.hidden_id").remove();
    $(".advancedPackage").find("ul").removeClass("selected");
    $("li.count").find("select").attr("name", "");
    $("li.title").css("background-color", "#333");

    $(this).find("ul").addClass("selected");
    $(this).find("li.title").css("background-color", "#cc1212");
    var id = $(this).attr("data-id");
    $(this).find("ul").find("li.count").append('<input type="hidden" class="hidden_id" name="register[packageId]" value="'+ id +'">');
    $(this).find("ul").find("li.count").find("select").attr("name", "register[lessonCount]");

});



$("#RegisterIntrestedIn").change(function (e) {
    $("p.noinstrument").fadeOut(0);
    $("#panel2-2").find(".advancedPackage").fadeOut(0);
    var instrument = $(this).val();
    console.log(instrument);
    if(instrument === "coupon"){
        $("a[href='#panel2-2']").parent().removeClass("active");
        $("a[href='#panel2-3']").parent().addClass("active");
        $("#panel2-3").addClass("active");
        $("#panel2-2").removeClass("active");
        $(".changeCoupon").html("Gutscheincode eingeben");
        $("p.noinstrument").fadeIn(0);
    }else{
        $("a[href='#panel2-2']").parent().addClass("active");
        $("a[href='#panel2-3']").parent().removeClass("active");
        $("#panel2-2").addClass("active");
        $("#panel2-3").removeClass("active");
        $(".changeCoupon").html("Weiter zur Dozenten-Auswahl");
    }
    $("#panel2-2").find("." + instrument).fadeIn(500);
});

$("input.overviewData").change(function (e) {
    var value = $(this).val();
    var label = $(this).attr("placeholder");
    if(typeof $("." + label).html() !== "undefined"){
        $("." + label).html(""+ label +": " + value + "");
    }else{
        $(".orderOverview").append("<li class='"+label+"'>"+ label +": " + value + "</li>")
    }
});

$("input.overviewPayment").change(function (e) {
    var value = $(this).next().html();
    var label = $(this).attr("placeholder");
    if(typeof $("." + label).html() !== "undefined"){
        $("." + label).html(""+ label +": " + value + "");
    }else{
        $(".orderOverview").append("<li class='"+label+"'>"+ label +": " + value + "</li>")
    }
});

$(".next").click(function (e) {
    e.preventDefault();
    $(this).fadeToggle(0);
    console.log($(this).parent());
    if($("#couponCode").val() !== ""){
        $(this).parent().next().next().removeClass("opacityhidden");
    }else{
        $(this).parent().next().removeClass("opacityhidden");
    }

    $('html, body').animate({
        scrollTop: $($(this).parent().next()).offset().top
    }, 1000);
})

$("select.overviewData").change(function (e) {
    var value = $("option[value=" + $(this).val() + "]").html();
    var label = $(this).prev().html();
    if(typeof $("." + label).html() !== "undefined"){
        console.log(value);

        $("." + label).html(""+ label +": " + value + "");
    }else{

        $(".orderOverview").append("<li class='"+label+"'>"+ label +": " + value + "</li>")
    }
});

