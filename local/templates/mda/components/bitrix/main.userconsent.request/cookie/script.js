$(document).ready(function () {
    let node = $('[data-cookie]');
    let height = $(node).height() + 30;
    $(node).css({
        top: 'unset',
        bottom: -1 * height + 'px',
    });
    $(node).animate(
        {
            bottom: '0',
            opacity: 1,
        },
        1000
    );

    $('[data-cookie-button]').on('click', function () {
        $(node).animate(
            {
                bottom: -1 * height + 'px',
                opacity: 0,
            },
            1000,
            function () {
                $(node).remove();
            }
        );
    });
});