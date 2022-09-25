<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var array $arParams
 */

$dom = new DOMDocument('1.0', 'UTF-8');

foreach ($arResult["QUESTIONS"] as $FIELD_SID => &$question) {

    $tagList = [
        'input',
        'textarea'
    ];

    $dom->loadHTML("\xEF\xBB\xBF" . $question["HTML_CODE"]);

    foreach ($tagList as $tag) {
        foreach ($dom->getElementsByTagName($tag) as $item) {
//            $item->setAttribute('placeholder', ($question['REQUIRED'] == 'Y' ? '* ' : '') . $question['CAPTION']);
            $item->setAttribute('class', 'form__'.$tag);
            $item->setAttribute('id', $FIELD_SID.'_'.$question['STRUCTURE'][0]['FIELD_ID']);
            if($arParams['FIELDS'][$FIELD_SID]) {
                $item->setAttribute('value', $arParams['FIELDS'][$FIELD_SID]);
            }
        }
    }

    $question["HTML_CODE"] = html_entity_decode($dom->saveHTML());
}
