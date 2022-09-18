<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var array $paymentData */
/** @var string $templateFolder */
/** @global CMain $APPLICATION */

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

if ($arParams['GUEST_MODE'] !== 'Y')
{
    Asset::getInstance()->addJs("/local/templates/mda/components/bitrix/sale.order.payment.change/.default/script.js");
//	Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
//	Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
}
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");

/**
 * clipboard - копирование при нажатии на иконку
 * fx - подгрузка платежных систем в "Сменить способ оплаты"
 */
CJSCore::Init(array('clipboard', 'fx'));

$APPLICATION->SetTitle(Loc::getMessage('SPOD_LIST_MY_ORDER', [
    '#ACCOUNT_NUMBER#' => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
    '#DATE_ORDER_CREATE#' => $arResult["DATE_INSERT_FORMATED"]
]));
?>


<?if (!empty($arResult['ERRORS']['FATAL'])):?>

    <?
	foreach ($arResult['ERRORS']['FATAL'] as $error) {
		ShowError($error);
	}

	$component = $this->__component;

	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}
    ?>

<?else:?>

    <?/** Ошибки */?>
    <?
	if (!empty($arResult['ERRORS']['NONFATAL'])) {
		foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
			ShowError($error);
		}
	}
    ?>

    <? require __DIR__ . '/include/order.php'; ?>

	<?
	$javascriptParams = array(
		"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
		"templateFolder" => CUtil::JSEscape($templateFolder),
		"templateName" => $this->__component->GetTemplateName(),
		"paymentList" => $paymentData,
		"returnUrl" => $arResult['RETURN_URL'],
	);
	$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
	?>

	<script>
		BX.Sale.PersonalOrderComponent.PersonalOrderDetail.init(<?=$javascriptParams?>);
	</script>

<?endif;?>

