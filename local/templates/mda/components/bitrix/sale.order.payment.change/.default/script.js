BX.namespace('BX.Sale');

BX.Sale.OrderPaymentChange = (function()
{
	var classDescription = function(params)
	{
		this.ajaxUrl = params.url;
		this.accountNumber = params.accountNumber || {};
		this.paymentNumber = params.paymentNumber || {};
		this.wrapperId = params.wrapperId || "";
		this.onlyInnerFull = params.onlyInnerFull || "";
		this.pathToPayment = params.pathToPayment || "";
		this.returnUrl = params.returnUrl || "";
		this.templateName = params.templateName || "";
		this.refreshPrices = params.refreshPrices || "N";
		this.inner = params.inner || "";
		this.templateFolder = params.templateFolder;
		this.wrapper = document.getElementById('bx-sopc'+ this.wrapperId);

		this.paySystemsContainer = this.wrapper.getElementsByClassName('order-detail__payment-new')[0];
		BX.ready(BX.proxy(this.init, this));
	};

	classDescription.prototype.init = function()
	{
		/*
		var paymentNewList = this.wrapper.getElementsByClassName('order-detail__payment-new-list')[0];

		new BX.easing({
			duration: 300,
			start: {opacity: 0, height: 0},
			finish: {opacity: 100, height: paymentNewList.clientHeight},
			transition: BX.easing.makeEaseOut(BX.easing.transitions.quad),
			step: function(state)
			{
				paymentNewList.style.opacity = state.opacity / 100;
				paymentNewList.style.height = state.height + 'px';
			},
			complete: function()
			{
				paymentNewList.style.height = 'auto';
			}
		}).animate();
		*/

		BX.bindDelegate(this.paySystemsContainer, 'click', { 'className': 'order-detail__payment-new-item' }, BX.proxy(
			function(event) {

				var targetParentNode = event.target.parentNode;
				var hidden = targetParentNode.getElementsByClassName("order-detail__payment-new-input")[0];

				pre(this.ajaxUrl);
				BX.ajax({
					method: 'POST',
					dataType: 'html',
					url: this.ajaxUrl,
					data:
					{
						sessid: BX.bitrix_sessid(),
						paySystemId: hidden.value,
						accountNumber: this.accountNumber,
						paymentNumber: this.paymentNumber,
						inner: this.inner,
						templateName: this.templateName,
						refreshPrices: this.refreshPrices,
						onlyInnerFull: this.onlyInnerFull,
						pathToPayment: this.pathToPayment,
						returnUrl: this.returnUrl,
					},
					onsuccess: BX.proxy(function(result) {

						window.location.reload();

						return this;
						let paymentItem = this.paySystemsContainer.closest('.order-detail__payment-item');
						let paymentBox = $(paymentItem).find('.order-detail__payment-box');

						$(paymentItem).toggleAttr('data-pay');
						$(paymentItem).toggleAttr('data-change');

						$(paymentBox).html(result);

						this.paySystemsContainer.remove();

						if (this.wrapper.parentNode.previousElementSibling) {
							var detailPaymentImage = this.wrapper.parentNode.previousElementSibling.getElementsByClassName("order-detail__payment-image")[0];
							if (detailPaymentImage !== undefined) {

								// 'order-detail__item-title'

								detailPaymentImage.setAttribute('src', targetParentNode.getElementsByClassName("order-detail__payment-new-item-image")[0].getAttribute('src'));
							}
						}
					},this),
					onfailure: BX.proxy(function() {
						return this;
					}, this)
				}, this);
				return this;
			}, this)
		);
		return this;
	};

	return classDescription;
})();

BX.Sale.OrderInnerPayment = (function()
{
	var paymentDescription = function(params)
	{
		this.ajaxUrl = params.url;
		this.accountNumber = params.accountNumber || {};
		this.paymentNumber = params.paymentNumber || {};
		this.wrapperId = params.wrapperId || "";
		this.valueLimit =  parseFloat(params.valueLimit) || 0;
		this.templateFolder = params.templateFolder;
		this.wrapper = document.getElementById('bx-sopc'+ this.wrapperId);
		this.inputElement = this.wrapper.getElementsByClassName('inner-payment-form-control')[0];
		this.sendPayment = this.wrapper.getElementsByClassName('sale-order-inner-payment-button')[0];
		BX.ready(BX.proxy(this.init, this));
	};

	paymentDescription.prototype.init = function()
	{
		BX.bind(this.inputElement, 'input', BX.delegate(
			function ()
			{
				this.inputElement.value = this.inputElement.value.replace(/[^\d,.]*/g, '')
					.replace(/,/g, '.')
					.replace(/([,.])[,.]+/g, '$1')
					.replace(/^[^\d]*(\d+([.,]\d{0,2})?).*$/g, '$1');

				var value = parseFloat(this.inputElement.value);

				if (value > this.valueLimit)
				{
					this.inputElement.value = this.valueLimit;
				}
				if (value <= 0)
				{
					this.inputElement.value = 0;
					this.sendPayment.classList.add('inactive-button');
				}
				else
				{
					this.sendPayment.classList.remove('inactive-button');
				}
			}, this)
		);

		BX.bind(this.sendPayment, 'click', BX.delegate(
			function ()
			{
				if (event.target.classList.contains("inactive-button"))
				{
					return this;
				}
				event.target.classList.add("inactive-button");
				BX.ajax(
					{
						method: 'POST',
						dataType: 'html',
						url: this.ajaxUrl,
						data:
						{
							sessid: BX.bitrix_sessid(),
							accountNumber: this.accountNumber,
							paymentNumber: this.paymentNumber,
							inner: "Y",
							onlyInnerFull: this.onlyInnerFull,
							paymentSum: this.inputElement.value,
							returnUrl: this.returnUrl,
						},
						onsuccess: BX.proxy(function(result)
						{
							if (result.length > 0)
								this.wrapper.innerHTML = result;
							else
								window.location.reload();
						},this),
						onfailure: BX.proxy(function()
						{
							return this;
						}, this)
					}, this
				);
				return this;
			}, this)
		);
	};

	return paymentDescription;
})();