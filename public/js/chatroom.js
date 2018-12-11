/**
 * Created by mstoc on 06.11.2016.
 */

var room = window.location.href.split("raum=")[1];

var audioDevices = [];
var videoDevices = [];
var webrtc;
var established = false;


var mediaOptions = {
    audio: true,
    video: true
};



function selectAudio(id){
    mediaOptions.audio = {
        deviceId: id
    };

    $(".inputs_audio button").removeClass("active").removeClass("done");
    $("button[data-source="+id+"]").addClass("active");

}

function reJoin(){
    webrtc.leaveRoom();
    webrtc = new SimpleWebRTC({
        // the id/element dom element that will hold "our" video
        localVideoEl: 'localVideo',
        // the id/element dom element that will hold remote videos
        remoteVideosEl: 'remoteVideos',
        // immediately ask for camera access
        autoRequestMedia: true,
        peerVolumeWhenSpeaking: 0,
        media: mediaOptions

    });
    webrtc.joinRoom(room);
}

function selectVideo(id){
    mediaOptions.video = {
        deviceId: id
    };

    $(".inputs_video button").removeClass("active").removeClass("done");
    $("button[data-source="+id+"]").toggleClass("active");
}


function start(){

    browser = navigator.sayswho.split(" ");
    console.log(browser);
    if (browser[0] != 'Firefox') {
        $(".gears").fadeIn(0).css("display", "inline-block");
    }
    if($(".inputs_audio button, .inputs_video button").hasClass("active")){

        $(".inputs_audio button.active, .inputs_video button.active").addClass("done");
        $(".inputs_audio button, .inputs_video button").removeClass("active");
    }
    $(".room").fadeIn(500);
    $(".start").remove();
    if(!established){
        webrtc = new SimpleWebRTC({
            // the id/element dom element that will hold "our" video
            localVideoEl: 'localVideo',
            // the id/element dom element that will hold remote videos
            remoteVideosEl: 'remoteVideos',
            // immediately ask for camera access
            autoRequestMedia: true,
            //peerVolumeWhenSpeaking: 1,
            media: mediaOptions

    });


    webrtc.on('readyToCall', function () {
        // you can name it anything
        webrtc.joinRoom(room);

    });
    established = true;
    }else{
        reJoin();
    }

}




$(document).ready(function(){

    navigator.sayswho = (function () {
        var ua = navigator.userAgent, tem,
            M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
        if (/trident/i.test(M[1])) {
            tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
            return 'IE ' + (tem[1] || '');
        }
        if (M[1] === 'Chrome') {
            tem = ua.match(/\bOPR\/(\d+)/)
            if (tem != null) return 'Opera ' + tem[1];
        }
        M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
        if ((tem = ua.match(/version\/(\d+)/i)) != null) M.splice(1, 1, tem[1]);
        return M.join(' ');
    })();

    navigator.mediaDevices.enumerateDevices().then(function (devices) {
        console.log(devices)
        for (var i = 0; i !== devices.length; ++i) {

            var device = devices[i];

            if (device.kind === 'audioinput') {

                device.label = device.label || 'microphone ' + (audioDevices.length + 1);
                audioDevices.push(device);
                $(".inputs_audio").append(
                    "<button style='display: inline-block; font-size: 14px; margin-top:5px;'  class=' button tiny small-3 medium-3 large-3 ' data-source='" + device.deviceId + "'> " + device.label + "</button>"
                )
            } else if (device.kind === 'videoinput') {


                device.label = device.label || 'camera ' + (videoDevices.length + 1);
                videoDevices.push(device);
                $(".inputs_video").append(
                    "<button style='display: inline-block; font-size: 14px; margin-top:5px;'  class=' button tiny small-3 medium-3 large-3 ' data-source='" + device.deviceId + "'> " + device.label + "</button>"
                )
            }
        }
    });

    $(".gears").click(function(e){
        e.preventDefault();


        if($(this).attr("data-status") == "open"){
            $(this).html("Video-Einstellungen");
            $(this).attr("data-status", "close");
        }
        else if($(this).attr("data-status") == "close"){
            $(this).html("Einstellungen ausblenden");
            $(this).attr("data-status", "open");
        }
       $(".settings").fadeToggle(500);
    });

    $("body").on("click", ".inputs_audio button", function(){
        selectAudio($(this).attr("data-source"))
    })
    $("body").on("click", ".inputs_video button", function(){
        selectVideo($(this).attr("data-source"))
    })
})

