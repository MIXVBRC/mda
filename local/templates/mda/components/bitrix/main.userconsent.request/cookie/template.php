<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__DIR__ . '/user_consent.php');
$config = \Bitrix\Main\Web\Json::encode($arResult['CONFIG']);

$linkClassName = 'main-user-consent-request-announce';
if ($arResult['URL'])
{
	$url = htmlspecialcharsbx(\CUtil::JSEscape($arResult['URL']));
	$label = htmlspecialcharsbx($arResult['LABEL']);
	$label = explode('%', $label);
	$label = implode('', array_merge(
		array_slice($label, 0, 1),
		['<a href="' . $url  . '" target="_blank">'],
		array_slice($label, 1, 1),
		['</a>'],
		array_slice($label, 2)
	));
}
else
{
	$label = htmlspecialcharsbx($arResult['INPUT_LABEL']);
	$linkClassName .= '-link';
}
pre($arResult);
?>

<form name="FORM_COOKIE" action="<?=$arResult['CONFIG']['actionUrl']?>" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?=$arResult['CONFIG']['id']?>">
    <input type="hidden" name="sec" value="<?=$arResult['CONFIG']['sec']?>">
    <input type="hidden" name="replace[]" value="<?=$arResult['CONFIG']['replace']?>">
    <input type="hidden" name="url" value="<?=$arResult['CONFIG']['url']?>">
    <input type="hidden" name="action" value="saveConsent">
    <input type="hidden" name="AJAX_CALL" value="Y">

    <div class="cookie" data-cookie>
        <div class="cookie__body">
            <div class="cookie__text">
                <?=$arResult['CONFIG']['text']?>
            </div>
            <input type="submit" class="cookie__button button__medium" value="Понятно" data-bubble data-cookie-button>
        </div>
    </div>
</form>


