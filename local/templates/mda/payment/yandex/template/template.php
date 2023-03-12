<?
	use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Page\Asset::getInstance()->addCss("/bitrix/themes/.default/sale.css");
	Loc::loadMessages(__FILE__);

	$sum = round($params['PAYMENT_SHOULD_PAY'], 2);
?>
<div class="mb-4" style="border-top: 1px solid #fff; padding-top: 15px;">
	<p><?=Loc::getMessage('SALE_HANDLERS_PAY_SYSTEM_YANDEX_DESCRIPTION')." <strong>".SaleFormatCurrency($params['PAYMENT_SHOULD_PAY'], $payment->getField('CURRENCY'))."</strong>";?></p>
	<form id="paysystem-yandex-form" name="ShopForm" action="<?=$params['URL'];?>" method="post">

		<input type="hidden" name="ShopID" value="<?=htmlspecialcharsbx($params['YANDEX_SHOP_ID']);?>" >
		<input type="hidden" name="scid" value="<?=htmlspecialcharsbx($params['YANDEX_SCID']);?>" >
		<input type="hidden" name="customerNumber" value="<?=htmlspecialcharsbx($params['PAYMENT_BUYER_ID']);?>" >
		<input type="hidden" name="orderNumber" value="<?=htmlspecialcharsbx($params['PAYMENT_ID']);?>" >
		<input type="hidden" name="Sum" value="<?=number_format($sum, 2, '.', '')?>" >
		<input type="hidden" name="paymentType" value="<?=htmlspecialcharsbx($params['PS_MODE'])?>" >
		<input type="hidden" name="cms_name" value="1C-Bitrix" >
		<input type="hidden" name="BX_HANDLER" value="YANDEX" >
		<input type="hidden" name="BX_PAYSYSTEM_CODE" value="<?=$params['BX_PAYSYSTEM_CODE']?>" >

		<div class="d-flex align-items-center justify-content-start mb-4">
            <br>
			<input class="button__success" name="BuyButton" value="<?=Loc::getMessage('SALE_HANDLERS_PAY_SYSTEM_YANDEX_BUTTON_PAID')?>" type="submit">
            <br>
            <br>
            <p class="m-0 p-3"><?=Loc::getMessage('SALE_HANDLERS_PAY_SYSTEM_YANDEX_REDIRECT_MESS');?></p>
		</div>
        <br>
		<div class="alert alert-info"><?=Loc::getMessage('SALE_HANDLERS_PAY_SYSTEM_YANDEX_WARNING_RETURN');?></div>
        <br>
	</form>
</div>