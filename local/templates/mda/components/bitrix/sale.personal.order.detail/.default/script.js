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
			var buttonInfoShow = document.getElementsByClassName('info-show')[0];
			var buttonInfoHide = document.getElementsByClassName('info-hide')[0];
			var infoBox = document.getElementsByClassName('info-box')[0];
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
			var listShipmentWrapper = document.getElementsByClassName('order-detail__shipment-item');
			Array.prototype.forEach.call(listShipmentWrapper, function(shipmentWrapper) {

				var shipmentBox = shipmentWrapper.getElementsByClassName('order-detail__shipment-box')[0];
				var buttonShipmentShow = shipmentWrapper.getElementsByClassName('order-detail__shipment-show')[0];
				var buttonShipmentHide = shipmentWrapper.getElementsByClassName('order-detail__shipment-hide')[0];



				BX.bindDelegate(shipmentWrapper, 'click', { 'class': 'order-detail__shipment-show' }, BX.proxy(function() {
					buttonShipmentShow.style.display = 'none';
					buttonShipmentHide.style.display = 'inline-block';
					shipmentBox.style.display = 'block';

					new BX.easing({
						duration: 300,
						start: {opacity: 0, height: 0},
						finish: {opacity: 100, height: shipmentBox.clientHeight},
						transition: BX.easing.makeEaseOut(BX.easing.transitions.quad),
						step: function(state)
						{
							shipmentBox.style.opacity = state.opacity / 100;
							shipmentBox.style.height = state.height + 'px';
						},
						complete: function()
						{
							shipmentBox.style.height = 'auto';
						}
					}).animate();

				}, this));
				BX.bindDelegate(shipmentWrapper, 'click', { 'class': 'order-detail__shipment-hide' }, BX.proxy(function() {
					buttonShipmentShow.style.display = 'inline-block';
					buttonShipmentHide.style.display = 'none';
					shipmentBox.style.display = 'none';
				}, this));
			});


			/** Сменить способ оплаты AND оплата */
			var paymentItem = document.getElementsByClassName('payment-item');
			Array.prototype.forEach.call(paymentItem, function(paymentWrapper) {

				/** Ооплата */
				BX.bindDelegate(paymentWrapper, 'click', { 'class': 'payment-pay' }, BX.proxy(function() {
					$(paymentWrapper).toggleAttr('data-pay');
				}, this));
				BX.bindDelegate(paymentWrapper, 'click', { 'class': 'payment-cancel' }, BX.proxy(function() {
					$(paymentWrapper).toggleAttr('data-pay');
				}, this));

				/** Сменить способ оплаты */
				var paymentInfo = paymentWrapper.getElementsByClassName('payment-change-box')[0];
				BX.bindDelegate(paymentWrapper, 'click', { 'class': 'payment-change' }, BX.proxy(function(event) {
					event.preventDefault();

					var paymentBack = paymentWrapper.getElementsByClassName('payment-back')[0];

					// Фикс двойного наложения события click после ajax
					BX.unbindAll(paymentBack);

					BX.ajax({
						method: 'POST',
						dataType: 'html',
						async: false,
						url: params.url,
						data: {
							sessid: BX.bitrix_sessid(),
							orderData: params.paymentList[event.target.id],
							templateName : params.templateName,
							returnUrl: params.returnUrl,
						},
						onsuccess: BX.proxy(function(result) {

							paymentInfo.innerHTML = result;

							BX.bind(paymentBack, 'click', function(eventBack) {
								eventBack.preventDefault();
								$(paymentWrapper).toggleAttr('data-change');
								paymentInfo.innerHTML = '';
								// window.location.reload();
							},this);

							$(paymentWrapper).toggleAttr('data-change');

						},this),
						onfailure: BX.proxy(function() {

							$(paymentWrapper).removeAttr('data-change');
							$(paymentWrapper).removeAttr('data-pay');

							return this;

						}, this)
					}, this);
				}, this));
			});
		}
	};
})();
