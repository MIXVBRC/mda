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

    // inputmask
    $('[data-phone-mask]').inputmask("+7 (999) 999-99-99");

    // burger
    $('[data-menu-burger]').on('click', function (event) {
        $('[data-menu-burger]').toggleAttr('data-active');
        $('[data-menu-top]').toggleAttr('data-active');
        $('[data-header]').toggleAttr('data-active');
        $('html, body').toggleAttr('menu-open');
    });
    $(window).resize(function() {
        if ($(window).width() <= 768) return;
        $('[data-menu-top]').css({'margin-top' : ''});
        $('[data-menu-burger]').removeAttr('data-active');
        $('[data-menu-top]').removeAttr('data-active');
        $('[data-header]').removeAttr('data-active');
        $('html, body').removeAttr('menu-open');
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
    $(this).on('click', '[data-popup-form]', function (event) {

        event.preventDefault();

        if (!$(this).attr('href')) return;

        $('[data-popup-content]').html('');

        $.ajax({
            type: 'POST',
            url: $(this).attr('href'),
            async: false,
            data: {
                WEB_FORM_ID: $(this).data('popup-form'),
                FIELDS: JSON.stringify({
                    POST: $(this).data('popup-fields-post')
                }),
            },
            success: function (data) {
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

            let speed = 400,
                boobleList = $('.button, .button__success, .button__medium, .button__error'),
                style = {
                    position: 'absolute',
                    borderRadius: '50%',
                    zIndex: '-1'
                };

            $(boobleList).toggleAttr('data-bubble');

            $(boobleList).css({
                position: 'relative',
                overflow: 'hidden',
                zIndex: '0'
            });

            $(document).on('mouseenter', '[data-bubble]', function (event) {

                let booble = $('<div data-bubble-in></div>'),
                    width = $(this).width() * 3,
                    height = width * $(this).height() / 20;

                $(booble).css(style);

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

            $(document).on('mouseleave', '[data-bubble]', function (event) {

                let booble = $('<div data-bubble-out></div>'),
                    width = $(this).width() * 3,
                    height = width * $(this).height() / 20;

                $(booble).css({
                    left: event.offsetX + 'px',
                    top: event.offsetY + 'px'
                });

                $(booble).css(style);

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

    (function () {
        $(document).on('click', '[data-opener]', function () {
            $(this).parents('[data-item]').toggleAttr('data-close');
        });
    })();

    // age
    (function () {
        if (!BX.getCookie('age')) {
            $('.age').css({
                display: 'flex',
            });
        }

        $(document).on('click', '[data-age-button-yes]', function (event) {
            BX.setCookie('age', '1', {expires: 86400, path: 'mda-medusa.ru'});
            $('.age').css({
                display: 'none',
            });
        });

        $(document).on('click', '[data-age-button-no]', function (event) {
            window.location = 'https://www.google.ru/search?newwindow=1&ei=nZ_WWqywII3VwALf1bSwBg&q=%D0%BA%D0%BE%D0%B3%D0%B4%D0%B0+%D0%BC%D0%BD%D0%B5+%D0%B1%D1%83%D0%B4%D0%B5%D1%82+18+%D0%BB%D0%B5%D1%82%3F&oq=%D0%BA%D0%BE%D0%B3%D0%B4%D0%B0+%D0%BC%D0%BD%D0%B5+%D0%B1%D1%83%D0%B4%D0%B5%D1%82+18+%D0%BB%D0%B5%D1%82%3F&gs_l=psy-ab.12..0i22i30k1.2471.2471.0.3146.1.1.0.0.0.0.184.184.0j1.1.0....0...1c.1.64.psy-ab..0.1.183....0.Yc_wLYGb9kI';
        });
    })();
    
});

