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
    // BX.showWait = function(node, msg) {
    //     position = $(node).css('position');
    //     $(node).css({'position':'relative'});
    // };
    // BX.closeWait = function(node, obMsg) {
    //     $(node).css({'position':position});
    // };

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

    // bubble effect
    (function () {
        function bubble() {

            let speed = 500,
                boobleList = $('.button, .button__success, .button__medium, .button__error');

            $(boobleList).toggleAttr('data-bubble');

            $(boobleList).css({
                position: 'relative',
                overflow: 'hidden',
                zIndex: '0',
            });

            $('[data-bubble]').on('mouseenter', function (event) {

                let booble = $('<div data-bubble-in></div>'),
                    width = $(this).width() * 3,
                    height = width * $(this).height() / 20;

                $(booble).css({
                    position: 'absolute',
                    borderRadius: '50%',
                    zIndex: '-1',
                });

                $(this).append(booble);

                $(booble).css({
                    left: event.offsetX + 'px',
                    top: event.offsetY + 'px'
                });

                $(booble).css({
                    width: '0',
                    height: '0',
                    opacity: '1',
                    marginTop: '0',
                    marginLeft: '0'
                }).animate({
                    width: width + 'px',
                    height: height + 'px',
                    opacity: '0',
                    marginTop: -height / 2 + 'px',
                    marginLeft: -width / 2 + 'px'
                }, speed, function () {
                    $(booble).remove();
                });
            });

            $('[data-bubble]').on('mouseleave', function (event) {

                let booble = $('<div data-bubble-out></div>'),
                    width = $(this).width() * 3,
                    height = width * $(this).height() / 20;

                $(booble).css({
                    left: event.offsetX + 'px',
                    top: event.offsetY + 'px'
                });

                $(booble).css({
                    position: 'absolute',
                    borderRadius: '50%',
                    zIndex: '-1',
                });

                $(this).append(booble);

                $(booble).css({
                    width: width + 'px',
                    height: height + 'px',
                    opacity: 0,
                    marginTop: -height / 2 + 'px',
                    marginLeft: -width / 2 + 'px'
                }).animate({
                    left: event.offsetX + 'px',
                    top: event.offsetY + 'px',
                    width: '0',
                    height: '0',
                    opacity: '1',
                    marginTop: '0',
                    marginLeft: '0'
                }, speed, function () {
                    $(booble).remove();
                });
            });
        }
        bubble();
        BX.addCustomEvent('onAjaxSuccess', bubble);
    })();

    // inputmask
    $('[data-phone-mask]').inputmask("+7 (999) 999-99-99");

});