/**
 * Created by mstoc on 05.11.2016.
 */
var browser;
var vid = document.getElementById("video");
var source;

function videoLoad(event, src) {
    browser = navigator.sayswho.split(" ");
    event.preventDefault();

    source = $("#video source");
    $("div.flex-video").fadeIn();

    if (browser[0] == 'Firefox' || browser[0] == 'Opera') {
        source.attr('src', src + '.webmhd.webm');
        source.attr('type', 'video/webm');
    } else {
        source.attr('src', src + '.mp4');
        source.attr('type', 'video/mp4');
    }

    vid.load();
}


$(document).ready(function () {
    // Browserdetection
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


});
