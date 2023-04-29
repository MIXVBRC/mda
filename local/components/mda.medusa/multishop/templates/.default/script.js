this.MultiShop = {

    params: null,
    shops: null,
    shop: null,
    popups: null,
    animationTime: 300,

    init: function(params)
    {
        if (!params) throw new Error('Empty params.');

        this.params = params;
        this.shops = this.params.shops;
        this.shop = this.params.shop;

        if (params.animationTime) {
            this.animationTime = parseInt(params.animationTime);
        }

        for (let nodeName in this.params.nodes) {
            if (!this.params.nodes.hasOwnProperty(nodeName)) continue;
            this.params.nodes[nodeName] = $(this.params.nodes[nodeName]);
        }

        this.popups = {
            question: {
                node: this.params.nodes.question,
                active: false,
            },
            select: {
                node: this.params.nodes.select,
                active: false,
            },
        };

        if (this.params.showQuestion) {
            setTimeout(function (MultiShop) {
                MultiShop.popupShow('question');
            },1000, this);
        }

        this.bind(this.params.nodes.shop, 'click', 'shop');
        this.bind(this.params.nodes.shopsItem, 'click', 'select');
        this.bind(this.params.nodes.yes, 'click', 'yes');
        this.bind(this.params.nodes.no, 'click', 'no');
    },

    bind: function (node, type, action)
    {
        $(node).bind(type, {action:action}, this.distributor);
    },

    unbind: function (node, type)
    {
        $(node).unbind(type, this.distributor);
    },

    update: function (reload = false)
    {
        this.params.nodes.shop.find('span').text(this.shop.NAME);
        if (reload) location.reload();
    },

    popupShow: function (type)
    {
        let popup = this.popups[type];

        if (!popup) return;

        popup.active = true;

        popup.node.css({
            display: 'initial',
            opacity: 0
        });

        popup.node.animate(
            {opacity: 1},
            this.animationTime
        );
    },

    popupHide: function (type)
    {
        let popup = this.popups[type];

        if (!popup) return;

        popup.node.animate(
            {opacity: 0},
            this.animationTime,
            function () {
                popup.active = false;
                popup.node.css({display: 'none'});
            }
        );
    },

    popupToggle: function (type)
    {
        let popup = this.popups[type];

        if (popup.active) {
            this.popupHide(type);
        } else {
            this.popupShow(type);
        }
    },

    popupsHide: function ()
    {
        let popups = this.popups;
        for (let type in popups) {
            if (!popups.hasOwnProperty(type)) continue;
            let popup = popups[type];
            if (popup.active) {
                this.popupHide(type);
                break;
            }
        }
    },

    sendRequest: function(params)
    {
        let requestData = null;

        BX.ajax({
            url: this.params.templateFolder + '/ajax.php',
            data: params,
            method: 'POST',
            async: false,
            onsuccess: function(request) {
                requestData = JSON.parse(request);
            },
        });

        return requestData;
    },

    distributor: function(event)
    {
        let action = event.data.action;

        switch (action) {
            case 'select':
                let xmlId = $(event.target).data('multishop-shops-item');
                if (!xmlId) return;
                MultiShop.actionSelect(xmlId);
                MultiShop.popupsHide();
                break;
            case 'yes':
                MultiShop.popupsHide();
                MultiShop.actionYes();
                break;
            case 'shop':
            case 'no':
                MultiShop.popupsHide();
                MultiShop.popupToggle('select');
                break;
        }
    },

    actionSelect: function (xmlId)
    {
        this.shop = this.sendRequest({
            XML_ID: xmlId,
        });
        this.update(true);
    },

    actionYes: function ()
    {
        this.shop = this.sendRequest({
            XML_ID: this.shop['XML_ID'],
        });
        this.update();
    },
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
                // BX.ajax({
                //     url: './ajax.php',
                //     data: {
                //         AJAX_CALL: 'Y',
                //         ACTION: 'select',
                //     },
                //     method: 'POST',
                //     async: true,
                //     onsuccess: function(data) {
                //
                //     },
                // });
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