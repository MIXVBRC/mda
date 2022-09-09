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
?>
<label data-bx-user-consent="<?=htmlspecialcharsbx($config)?>" class="main-user-consent-request">
	<input type="checkbox" value="Y" <?=($arParams['IS_CHECKED'] ? 'checked' : '')?> name="<?=htmlspecialcharsbx($arParams['INPUT_NAME'])?>">
	<span class="<?=$linkClassName?>"><?=$label?></span>
</label>
<script type="text/html" data-bx-template="main-user-consent-request-loader">

    <div class="popup" data-popup data-popup-active>
        <div class="popup__body">
            <div class="popup__content" data-popup-content>
                <div class="form">
                    <div class="form__body">

                        <div data-bx-loader="" class="main-user-consent-request-loader">
                            <svg class="main-user-consent-request-circular" viewBox="25 25 50 50">
                                <circle class="main-user-consent-request-path" cx="50" cy="50" r="20" fill="none" stroke-width="1" stroke-miterlimit="10"></circle>
                            </svg>
                        </div>

                        <div data-bx-content class="form__form">

                            <div class="form__title" data-bx-head>Присоединяйся к нашей команде</div>

                            <div class="form__list">

                                <div class="form__item">
                                    <div data-bx-textarea></div>
                                </div>

                                <div class="form__item" data-bx-link>
                                    <div class="form__note"><?=Loc::getMessage('MAIN_USER_CONSENT_REQUEST_URL_CONFIRM')?></div>
                                    <a class="form__link" target="_blank"></a>
                                </div>

                                <div class="form__item">
                                    <span data-bx-btn-accept class="form__button">Y</span>
                                    <span data-bx-btn-reject class="form__button">N</span>
                                </div>

                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</script>

