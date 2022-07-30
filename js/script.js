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
});