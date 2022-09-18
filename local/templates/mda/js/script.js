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

        $('[data-menu-burger]').toggleAttr('data-active');
        $('[data-menu-top]').toggleAttr('data-active');
        $('[data-header]').toggleAttr('data-active');
    });

    $(window).resize(function() {
        if ($(window).width() <= 768) return;

        $('[data-menu-top]').css({'margin-top' : ''});
        $('[data-menu-burger]').removeAttr('data-active');
        $('[data-menu-top]').removeAttr('data-active');
        $('[data-header]').removeAttr('data-active');

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
    $('[data-popup-form]').on('click' ,function (event) {

        event.preventDefault();

        if (!$(this).attr('href')) return;

        $('[data-popup-content]').html('');

        $.ajax({
            type: 'POST',
            url: $(this).attr('href'),
            async: false,
            data: {
                WEB_FORM_ID: $(this).data('popup-form')
            },
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

    // button
    (function () {
        let button = $('.button, .button__success, .button__medium, .button__error');

        $(button).on('mouseenter', function (event) {

            $(this).children('[data-button-effect-enter]').remove();

            let effect = $('<div data-button-effect-enter></div>');
    
            $(effect).css({
                left: event.offsetX + 'px',
                top: event.offsetY + 'px',
            });
            
            $(this).append(effect);
    
            setTimeout(function(){
                $(effect).remove();
            }, 500);
            
        });
        $(button).on('mouseleave', function (event) {

            $(this).children('[data-button-effect-leave]').remove();

            let effect = $('<div data-button-effect-leave></div>');
    
            $(effect).css({
                left: event.offsetX + 'px',
                top: event.offsetY + 'px',
            });
            
            $(this).append(effect);
    
            setTimeout(function(){
                $(effect).remove();
            }, 500);
            
        });
    })();

    // inputmask
    $('[data-phone-mask]').inputmask("+7 (999) 999-99-99");

});