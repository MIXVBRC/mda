BX.namespace('BX.Sale.PersonalOrderComponent');

(function() {

	// Развернуть / свернуть
	$(document).on('click', '[data-opener-arrow]', function () {
		$(this).parents('[data-opener-item]').toggleAttr('data-opener-close');
	});

	// Делаем последний элемент списка заказов на всю ширину, если он нечетный
	$(document).ready(function () {
		let statusList = {};
		let itemList = {};
		$('[data-order-status-id]').each(function (key, item) {
			let id = $(item).data('order-status-id');
			statusList[id] = statusList[id] ? statusList[id] + 1 : 1;
			if (itemList[id]) itemList[id].push(item);
			else itemList[id] = [item];
		});
		for (let id in statusList) {
			if (statusList[id] % 2 === 0) continue;
			$(itemList[id].slice(-1)).attr('data-last-odd', '');
		}
	});


	BX.Sale.PersonalOrderComponent.PersonalOrderList = {
		init : function(params)
		{
			// var rowWrapper = document.getElementsByClassName('sale-order-list-inner-row');
			var rowWrapper = document.getElementsByClassName('order-list__status-item-body-item');

			params.paymentList = params.paymentList || {};
			params.url = params.url || "";
			params.templateName = params.templateName || "";
			params.returnUrl = params.returnUrl || "";

			Array.prototype.forEach.call(rowWrapper, function(wrapper)
			{

				// Идентификатор отправления
				var shipmentTrackingId = wrapper.getElementsByClassName('sale-order-list-shipment-id');
				if (shipmentTrackingId[0])
				{
					Array.prototype.forEach.call(shipmentTrackingId, function(blockId)
					{
						var clipboard = blockId.parentNode.getElementsByClassName('sale-order-list-shipment-id-icon')[0];
						if (clipboard)
						{
							BX.clipboard.bindCopyClick(clipboard, {text : blockId.innerHTML});
						}
					});
				}

				// Оплата
				BX.bindDelegate(wrapper, 'click', { 'class': 'ajax_reload' }, BX.proxy(function(event)
				{

					// var block = wrapper.getElementsByClassName('sale-order-list-inner-row-body')[0];
					// var block = wrapper.getElementsByClassName('order-list__status-item-body-item')[0];
					// var block = wrapper.getElementsByClassName('payment-button')[0];
					// var template = wrapper.getElementsByClassName('sale-order-list-inner-row-template')[0];
					// var template = wrapper.getElementsByClassName('payment-box')[0];
					var template = $(wrapper).find('[data-payment-body]')[0];
					// var cancelPaymentLink = template.getElementsByClassName('sale-order-list-cancel-payment')[0];
					// var cancelPaymentLink = template.getElementsByClassName('payment-cancel')[0];
					var cancelPaymentLink = $(wrapper).find('[data-payment-cancel]')[0];

					pre(template);
					BX.ajax(
						{
							method: 'POST',
							dataType: 'html',
							url: event.target.href,
							data:
							{
								sessid: BX.bitrix_sessid(),
								RETURN_URL: params.returnUrl
							},
							onsuccess: BX.proxy(function(result)
							{
								var resultDiv = document.createElement('div');
								resultDiv.innerHTML = result;
								$(template).append(resultDiv);
								// template.insertBefore(resultDiv, cancelPaymentLink);
								// block.style.display = 'none';
								// template.style.display = 'block';

								$(wrapper).attr('data-pay','');

								BX.bind(cancelPaymentLink, 'click', function()
								{
									// block.style.display = 'block';
									// template.style.display = 'none';
									$(wrapper).removeAttr('data-pay');
									resultDiv.remove();

								},this);

							},this),
							onfailure: BX.proxy(function()
							{
								return this;
							}, this)
						}, this
					);
					event.preventDefault();
				}, this));

				// сменить оплату
				BX.bindDelegate(wrapper, 'click', { 'class': 'payment_change' }, BX.proxy(function(event)
				{
					pre(1);
					event.preventDefault();

					// var block = wrapper.getElementsByClassName('sale-order-list-inner-row-body')[0];
					// var template = wrapper.getElementsByClassName('sale-order-list-inner-row-template')[0];
					var template = $(wrapper).find('[data-payment-body]')[0];
					// var cancelPaymentLink = template.getElementsByClassName('sale-order-list-cancel-payment')[0];
					var cancelPaymentLink = $(wrapper).find('[data-payment-cancel]')[0];

					BX.ajax(
						{
							method: 'POST',
							dataType: 'html',
							url: params.url,
							data:
							{
								sessid: BX.bitrix_sessid(),
								orderData: params.paymentList[event.target.id],
								templateName : params.templateName
							},
							onsuccess: BX.proxy(function(result)
							{
								var resultDiv = document.createElement('div');
								resultDiv.innerHTML = result;
								$(template).append(resultDiv);
								// template.insertBefore(resultDiv, cancelPaymentLink);
								// event.target.style.display = 'none';
								// block.parentNode.removeChild(block);
								// template.style.display = 'block';

								$(wrapper).attr('data-change','');

								BX.bind(cancelPaymentLink, 'click', function()
								{
									window.location.reload();
								},this);

							},this),
							onfailure: BX.proxy(function()
							{
								return this;
							}, this)
						}, this
					);

				}, this));
			});
		}
	};
})();
