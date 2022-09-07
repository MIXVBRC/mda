<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$dom = new DOMDocument('1.0', 'UTF-8');

foreach ($arResult["QUESTIONS"] as &$question) {

    $tagList = [
        'input',
        'textarea'
    ];

    $dom->loadHTML("\xEF\xBB\xBF" . $question["HTML_CODE"]);

    foreach ($tagList as $tag) {
        foreach ($dom->getElementsByTagName($tag) as $item) {
            $item->setAttribute('placeholder', ($question['REQUIRED'] == 'Y' ? '* ' : '') . $question['CAPTION']);
            $item->setAttribute('class', 'form__'.$tag);
        }
    }

    $question["HTML_CODE"] = html_entity_decode($dom->saveHTML());
}
