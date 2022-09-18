BX.namespace('BX.Sale.PersonalOrderComponent');

(function() {
	BX.Sale.PersonalOrderComponent.PersonalOrderDetail = {
		init : function(params) {

			/** Скопировать текст */
			var copyBox = document.getElementsByClassName('order-detail__copy-box');
			if (copyBox[0]) {
				Array.prototype.forEach.call(copyBox, function(blockId) {
					var copyButton = blockId.parentNode.getElementsByClassName('order-detail__copy')[0];
					if (copyButton) {
						BX.clipboard.bindCopyClick(copyButton, {text : blockId.innerHTML});
					}
				});
			}

			/** Показать информацию о заказе */
			var buttonInfoShow = document.getElementsByClassName('order-detail__info-show')[0];
			var buttonInfoHide = document.getElementsByClassName('order-detail__info-hide')[0];
			var infoBox = document.getElementsByClassName('order-detail__info-box')[0];
			BX.bind(buttonInfoShow, 'click', function() {
				infoBox.style.display = 'block';
				buttonInfoShow.style.display = 'none';
				buttonInfoHide.style.display = 'inline-block';
			},this);

			BX.bind(buttonInfoHide, 'click', function() {
				infoBox.style.display = 'none';
				buttonInfoShow.style.display = 'inline-block';
				buttonInfoHide.style.display = 'none';
			},this);

			/** Показать информацию о доставке */
			/*
			var buttonShipmentShow = document.getElementsByClassName('order-detail__shipment-show')[0];
			var buttonShipmentHide = document.getElementsByClassName('order-detail__shipment-hide')[0];
			var shipmentBox = document.getElementsByClassName('order-detail__shipment-box')[0];
			BX.bind(buttonShipmentShow, 'click', function() {
				shipmentBox.style.display = 'block';
				buttonShipmentShow.style.display = 'none';
				buttonShipmentHide.style.display = 'inline-block';
			},this);

			BX.bind(buttonShipmentHide, 'click', function() {
				shipmentBox.style.display = 'none';
				buttonShipmentShow.style.display = 'inline-block';
				buttonShipmentHide.style.display = 'none';
			},this);
			*/


			var listShipmentWrapper = document.getElementsByClassName('order-detail__shipment-item');
			Array.prototype.forEach.call(listShipmentWrapper, function(shipmentWrapper) {

				var shipmentBox = shipmentWrapper.getElementsByClassName('order-detail__shipment-box')[0];
				var buttonShipmentShow = shipmentWrapper.getElementsByClassName('order-detail__shipment-show')[0];
				var buttonShipmentHide = shipmentWrapper.getElementsByClassName('order-detail__shipment-hide')[0];

				BX.bindDelegate(shipmentWrapper, 'click', { 'class': 'order-detail__shipment-show' }, BX.proxy(function() {
					buttonShipmentShow.style.display = 'none';
					buttonShipmentHide.style.display = 'inline-block';
					shipmentBox.style.display = 'block';
				}, this));
				BX.bindDelegate(shipmentWrapper, 'click', { 'class': 'order-detail__shipment-hide' }, BX.proxy(function() {
					buttonShipmentShow.style.display = 'inline-block';
					buttonShipmentHide.style.display = 'none';
					shipmentBox.style.display = 'none';
				}, this));
			});


			/** Сменить способ оплаты */

			var paymentItem = document.getElementsByClassName('order-detail__payment-item');

			Array.prototype.forEach.call(paymentItem, function(paymentWrapper) {

				var paymentBox = paymentWrapper.getElementsByClassName('order-detail__payment-box')[0];

				BX.bindDelegate(paymentWrapper, 'click', { 'class': 'order-detail__payment-pay' }, BX.proxy(function() {
					$(paymentWrapper).toggleAttr('data-pay');
				}, this));

				BX.bindDelegate(paymentWrapper, 'click', { 'class': 'order-detail__payment-cancel' }, BX.proxy(function() {
					$(paymentWrapper).toggleAttr('data-pay');
				}, this));


				var paymentInfo = paymentWrapper.getElementsByClassName('order-detail__payment-info')[0];
				BX.bindDelegate(paymentWrapper, 'click', { 'class': 'order-detail__payment-change' }, BX.proxy(function(event) {
					event.preventDefault();

					var paymentPay = paymentWrapper.getElementsByClassName('order-detail__payment-pay')[0];
					var paymentBack = paymentWrapper.getElementsByClassName('order-detail__payment-back')[0];

					BX.ajax({
						method: 'POST',
						dataType: 'html',
						url: params.url,
						data: {
							sessid: BX.bitrix_sessid(),
							orderData: params.paymentList[event.target.id],
							templateName : params.templateName,
							returnUrl: params.returnUrl,
						},
						onsuccess: BX.proxy(function(result) {

							// paymentBox.innerHTML = result;
							paymentInfo.innerHTML = result;

							if (paymentPay) {
								$(paymentPay).remove();
								// btn.parentNode.removeChild(btn);
							}

							paymentBack.style.display = "inline-block";

							BX.bind(paymentBack, 'click', function() {

								window.location.reload();
							},this);

						},this),
						onfailure: BX.proxy(function() {

							return this;

						}, this)

					}, this);

				}, this));

			});

		}
	};
})();
