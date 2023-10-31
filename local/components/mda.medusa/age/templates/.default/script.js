this.AgeComponent = {
    init: function (params)
    {
        $(document).on('click', '[data-age-button-yes]', function (event) {
            BX.ajax({
                method: "POST",
                dataType: 'json',
                url: params.ajaxUrl,
                data: {
                    is_ajax_post: 'Y',
                },
                onsuccess: (data) => {
                    console.log(data);
                    $('.age').remove();
                },
                onfailure: function (error) {
                    alert('Произошла неизвестная ошибка.');
                    $('.age').remove();
                },
                headers: [{ name: 'X-Requested-With', value: 'XMLHttpRequest' }],
            });
        });

        $(document).on('click', '[data-age-button-no]', function (event) {
            window.location = 'https://www.google.ru/search?newwindow=1&ei=nZ_WWqywII3VwALf1bSwBg&q=%D0%BA%D0%BE%D0%B3%D0%B4%D0%B0+%D0%BC%D0%BD%D0%B5+%D0%B1%D1%83%D0%B4%D0%B5%D1%82+18+%D0%BB%D0%B5%D1%82%3F&oq=%D0%BA%D0%BE%D0%B3%D0%B4%D0%B0+%D0%BC%D0%BD%D0%B5+%D0%B1%D1%83%D0%B4%D0%B5%D1%82+18+%D0%BB%D0%B5%D1%82%3F&gs_l=psy-ab.12..0i22i30k1.2471.2471.0.3146.1.1.0.0.0.0.184.184.0j1.1.0....0...1c.1.64.psy-ab..0.1.183....0.Yc_wLYGb9kI';
        });
    },
};




/*
$(document).ready(function () {

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

});
*/