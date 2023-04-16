this.MultiShop = {

    params: null,

    init: function(params)
    {
        this.params = params;
        for (let nodeName in this.params.nodes) {
            if (!this.params.nodes.hasOwnProperty(nodeName)) continue;
            this.params.nodes[nodeName] = $(this.params.nodes[nodeName]);
        }

        if (this.params.showQuestion) {
            setTimeout(this.questionShow,1000);
        } else {
            this.params.nodes.question.remove();
        }

        $(this.params.nodes.selected).on('click', {action:'selected'}, this.sendRequest);
        $(this.params.nodes.yes).on('click', {action:'yes'}, this.sendRequest);
        $(this.params.nodes.no).on('click', {action:'no'}, this.sendRequest);
    },

    questionShow: function ()
    {
        let node = MultiShop.params.nodes.question;
        node.animate(
            {opacity: 1},
            1000
        );
    },

    questionHide: function ()
    {
        let node = MultiShop.params.nodes.question;
        node.animate(
            {opacity: 0},
            300,
            function () {
                node.remove();
            }
        );
    },

    sendRequest: function(event)
    {
        let action = event.data.action;
        switch (action) {
            case 'selected':
                MultiShop.setShop(MultiShop.params.shops[4]['XML_ID']);
                location.reload();
                break;
            case 'yes':
                MultiShop.questionHide();
                break;
            case 'no':
                MultiShop.questionHide();
                break;
        }

    },

    setShop: function (xmlId)
    {
        let cookieName = MultiShop.params.cookieName;

        while (true) {
            let cookie = BX.getCookie(cookieName);
            pre(cookie);
            if (!cookie) break;
            BX.setCookie(cookieName, '', {expires: -1});

        }

        BX.setCookie(cookieName, xmlId, {expires: 86400});

        // document.cookie = cookieName + '=;max-age=-1';
        //
        // let cookieDate = new Date();
        // cookieDate.setMonth(cookieDate.getMonth() + 1);
        // document.cookie = cookieName + '=' + xmlId + ';expires=' + cookieDate.toUTCString();
    }
}


// (function (window){
//
//     window.MDAMedusaMultiShop = function (params) {
//
//         this.templateFolder = null;
//         this.arParams = null;
//
//         if (typeof params === 'object') {
//             this.templateFolder = params.TEMPLATE_FOLDER;
//             this.arParams = params.PARAMS;
//         }
//     }
//
//     window.MDAMedusaMultiShop.prototype = {
//         init: function ()
//         {
//             let templateFolder = this.templateFolder;
//             let arParams = this.arParams;
//             console.log(arParams);
//
//             $('[data-multishop-popup-yes]').on('click', function () {
//                 $('[data-multishop-popup]').remove();
//             });
//
//             $('[data-multishop-popup-no]').on('click', function () {
//
//                 // BX.ajax({
//                 //     url: './ajax.php',
//                 //     data: {
//                 //         AJAX_CALL: 'Y',
//                 //         ACTION: 'select',
//                 //     },
//                 //     method: 'POST',
//                 //     async: true,
//                 //     onsuccess: function(data) {
//                 //
//                 //     },
//                 // });
//
//                 // $.ajax({
//                 //     // url: templateFolder + '/ajax.php',
//                 //     // url: templateFolder + '/ajax.php',
//                 //     method: 'post',
//                 //     data: {
//                 //         AJAX_CALL: 'Y',
//                 //         ACTION: 'select',
//                 //     },
//                 //     async: true,
//                 //     success: function (data) {
//                 //         $('[data-popup-content]').html(data);
//                 //         $('[data-popup]').toggleAttr('data-popup-active');
//                 //         console.log(data);
//                 //         // window.location.reload();
//                 //     }
//                 // });
//             });
//
//             $('[data-multishop-select]').on('click', function () {
//                 // $.ajax({
//                 //     url: templateFolder + '/ajax.php',
//                 //     method: 'post',
//                 //     data: {
//                 //         AJAX_CALL: 'Y',
//                 //         ACTION: 'select',
//                 //         SELECT: '25e08562-6ee1-11ed-87f7-1a89565b5ad6',
//                 //         PARAMS: arParams,
//                 //         // OFFERS_IBLOCK_ID: arParams.OFFERS_IBLOCK_ID,
//                 //         // PRODUCT_IBLOCK_ID: arParams.PRODUCT_IBLOCK_ID,
//                 //         // SHOP_HIGHLOAD_BLOCK_ID: arParams.SHOP_HIGHLOAD_BLOCK_ID,
//                 //         // STOCK_HIGHLOAD_BLOCK_ID: arParams.STOCK_HIGHLOAD_BLOCK_ID,
//                 //     },
//                 //     async: true,
//                 //     success: function (data) {
//                 //         console.log(data);
//                 //         // window.location.reload();
//                 //     }
//                 // });
//             });
//         },
//     }
//
// })(window)