// console log
function pre(data) {
    console.log(data);
}

// has attribute
$.fn.hasAttr = function(name) {
    let attr = $(this).attr(name);
    if (typeof attr !== typeof undefined && attr !== false) {
        return true;
    } else {
       return false;
    }
}

// toggle attribute
$.fn.toggleAttr = function(name) {
    if ($(this).hasAttr(name)) {
        $(this).removeAttr(name);
    } else {
        $(this).attr(name,'');
    }
}

$(document).ready(function () {

    $('[data-menu-burger]').on('click', function (event) {
        $('[data-menu-top]').css({'margin-top' : $('[data-header]').height() + 'px'});
        $('[data-menu-burger]').toggleAttr('data-active');
        $('[data-menu-top]').toggleAttr('data-active');
        $('[data-header]').toggleAttr('data-active');
    });

    $(window).resize(function() {
        if ($(window).width() > 768) {
            $('[data-menu-top]').css({'margin-top' : ''});
            $('[data-menu-burger]').removeAttr('data-active');
            $('[data-menu-top]').removeAttr('data-active');
            $('[data-header]').removeAttr('data-active');
        } else {
            $('[data-menu-top]').css({'margin-top' : $('[data-header]').height() + 'px'});
        }
    });


    let audio = new Audio();
    audio.src = '/local/templates/mda/audio/mda.mp3';

    $('[data-audio]').on('click', function (event) {

        $(this).toggleAttr('data-audio-play');

        if ($(this).hasAttr('data-audio-play')) {
            audio.play();
        } else {
            audio.pause();
        }

    });

    // ajax loading
    let position = 'initial';
    BX.showWait = function(node, msg) {
        position = $(node).css('position');
        $(node).css({'position':'relative'});
    };
    BX.closeWait = function(node, obMsg) {
        $(node).css({'position':position});
    };

    // popup open
    $('[data-popup-link]').on('click' ,function (event) {

        event.preventDefault();

        if (!$(this).attr('href')) return;

        $('[data-popup-content]').html('');

        $.ajax({
            type: 'POST',
            url: $(this).attr('href'),
            async: false,
            // data: {},
            success: function (data) {
                pre($('[data-popup]').hasAttr('data-popup-active'));
                $('[data-popup-content]').html(data);
                $('[data-popup]').toggleAttr('data-popup-active');
            }
        });

    });

    // popup close
    $('[data-popup-close]').on('click', function (event) {
        $(this).closest('[data-popup]').toggleAttr('data-popup-active');
        $('[data-popup-content]').html('');
    });

});