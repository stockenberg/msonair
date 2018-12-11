$(document).ready(function () {
    var paypal_url;
    /*
    $('#RegisterIndexForm').submit(function (e) {
        if (!$('#RegisterTermsOfUse').prop("checked")) {
            $('#flashMessage').css('position', 'fixed').css('top', '0px').fadeIn(500).html("Bitte akzeptiere die Datenschutz- und Nutzungsbestimmungen");
            e.preventDefault();
        }
        if ($('#RegisterTermsOfUse').prop("checked")) {
            return true;
        }
        setTimeout(function () {
            $('#flashMessage').fadeOut(500)
        }, 4000);
    });

    $('.beginnerswitch').click(function (e) {
        $('.advancedPackage').css('display', 'none');
        $('.coupons').css('display', 'none');
        $('.beginnerPackage').fadeIn(500);
        e.preventDefault();
        return false;
    });
    $('.couponswitch').click(function (e) {
        $('.advancedPackage').css('display', 'none');
        $('.beginnerPackage').css('display', 'none');
        $('.coupons').fadeIn(500);
        e.preventDefault();
        return false;
    });
    $('.advancedswitch').click(function (e) {
        $('.beginnerPackage').css('display', 'none');
        $('.coupons').css('display', 'none');
        $('.advancedPackage').fadeIn(500);
        e.preventDefault();
        return false;
    });

    setTimeout(function () {
        $('#flashMessage, .message').fadeOut(500)
    }, 4000);

    // Payment Switcher
    $('#RegisterChildsAccount').click(function () {
        if ($('#RegisterChildsAccount').prop("checked")) {
            $('#RegisterChildsName').fadeIn(500);
        } else {
            $('#RegisterChildsName').fadeOut(500);
        }
    });

    $('#payment').submit(function () {
        test = false;
        if (!$('.agb').prop("checked")) {
            $('#flashMessage').css('position', 'fixed').css('top', '0px').fadeIn(500).html("Bitte akzeptiere die Allgemeinen Geschäftsbedinungen");
            return false;
        }
        if (!$('.widerruf').prop("checked")) {
            $('#flashMessage').css('position', 'fixed').css('top', '0px').fadeIn(500).html("Bitte akzeptiere die Widerrufsbelehrung");
            return false;
        }
        if (!$('.paypal').prop("checked") && !$('.prepaid').prop("checked") && !$('.sofort').prop("checked")) {
            $('#flashMessage').css('position', 'fixed').css('top', '0px').fadeIn(500).html("Bitte wähle eine Zahlungsmethode");
            return false;
        }
        setTimeout(function () {
            $('#flashMessage').fadeOut(500)
        }, 4000);
    });

    */
    var room = location.search && location.search.split('?')[1];

    $('.bookLesson').click(function () {
        var value = window.confirm('Drücke auf Ok, um dem Studenten die gehaltene Stunde vom Kontingent abzuziehen.');
        if (value === false) {
            return false;
        } else {
            return true;
        }
    });

    $('input[type="submit"].delete').click(function () {
        var box = window.confirm('Möchtest du den Eintrag wirklich löschen?');
        if (box === false) {
            return false;
        } else {
            return true;
        }
    });
    $('#studentSelect select').change(function () {
        $('#studentSelect input[type="submit"]').trigger('click');
    });

    $('#teachersForm select').change(function () {
        $('#teachersForm input[type="submit"]').trigger('click');
    });

    var dragging = false;



    score = 0;
    score_edit = 0;
    deletescore = 0;


    $('#startLesson').click(function () {
        /*TEST*/
        $(this).fadeOut(200);
        $('.chat').fadeIn(0);
        var webrtc = new SimpleWebRTC({
            // the id/element dom element that will hold "our" video
            localVideoEl: 'localVideo',
            // the id/element dom element that will hold remote videos
            remoteVideosEl: 'remotesVideos',
            // immediately ask for camera access
            autoRequestMedia: true,
            peerVolumeWhenSpeaking: 1,
            media: {
                audio: {
                    optional: [
                        //{sourceId: audio_source},  // do it like this to take the default audio src
                        {googAutoGainControl: false},
                        {googEchoCancellation: false},
                        {googNoiseSuppression: false},
                        {googHighpassFilter: false},
                        {googTypingNoiseDetection: false},
                        {googAudioMirroring: false}
                    ]
                },
                video: {
                    mandatory: {
                        minWidth: 320,
                        minHeight: 180,
                        maxHeight: 640,
                        maxWidth: 360,
                        maxFrameRate: 30
                    },
                    optional: [
                        //{sourceId: video_source}   // do it like this else video does not show at all
                    ]
                }
            }
        });

        webrtc.on('readyToCall', function () {
            // you can name it anything
            webrtc.joinRoom(room);
        });
        /*
        $('.dynText').html('Unterricht läuft...')
        $('.bookLesson').html('<a class="bookLesson tiny button" href="/myschool/manage/lessonmanagement/bookSession/' + room + '">Stunde hat stattgefunden</a>');
        if (data_one == 'yxcmyxckjasfl928') {
            $('.lessonEnd').html('<a class="button tiny" href="/myschool/manage/lessonmanagement" onclick="">Raum verlassen</a>');
        } else if (data_one == 'hasdufk123') {
            $('.lessonEnd').html('<a class="button tiny" href="/myschool/lesson">Raum verlassen</a>');

        }
        */
    });

    if (typeof array !== 'undefined') {
        var param = array;
    }

    $('dd').click(
        function (e) {
            $('dd').removeClass('active');
            $(e.currentTarget).addClass('active');
        }
    );

    // TODO : Start Rebuilding Script




});