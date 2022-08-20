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

    var audio = new Audio();

    audio.src = '/local/templates/mda/audio/mda.mp3';

    $('[data-audio]').on('click', function (event) {

        $(this).toggleAttr('data-audio-play');

        if ($(this).hasAttr('data-audio-play')) {
            audio.play();
            pre(1);
        } else {
            audio.pause();
            pre(0);
        }

    });
});

// $(document).ready(function () {
//     $('[data-add2basket]').on('click', function (event) {
//         let product = $(this).data('product');
//
//         $.ajax({
//             type: 'POST',
//             url: '/include/add2basket.php',
//             data: {
//                 product: product
//             }
//         });
//
//         $.ajax({
//             type: 'POST',
//             url: '/include/basket-small.php',
//             success: function (data) {
//                 $('[data-basket-small]').html(data);
//             }
//         });
//     });
// });