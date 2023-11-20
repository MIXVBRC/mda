<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$strItemEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");

if ($arResult['ITEMS']):?>

    <section class="popular-elements">
        <div class="container">
            <h2 class="popular-elements__title main__title"><?= $arParams['TITLE'] ?></h2>

        </div>
        <div class="popular-elements__body">
            <div class="swiper">

                <!--                    <div class="popular-elements__list">-->
                <div class="swiper-wrapper">

                    <?foreach ($arResult['ITEMS'] as $item):?>

                        <?
                        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], $strItemEdit);

                        $picture = $item['PREVIEW_PICTURE']['SRC'] ?: ($item['DETAIL_PICTURE']['SRC'] ?: MDA_NO_PHOTO);
                        ?>

                        <div class="swiper-slide">
                            <div class="popular-elements__item" id="<?= $this->GetEditAreaId($item['ID']) ?>">
                                <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="popular-elements__link">
                                    <img src="<?= $picture ?>" alt="<?= $item['NAME'] ?>" class="popular-elements__img img__cover">
                                    <div class="popular-elements__name"><?= $item['NAME'] ?></div>
                                </a>
                            </div>
                        </div>
                    <?endforeach;?>

                </div>

                <div class="swiper-pagination"></div>

            </div>
            <!--                <div class="popular-elements__right">-->
            <!--                    --><?//if ($arResult['IMAGE']):?>
            <!--                        <img class="img__cover" src="--><?//= $arResult['IMAGE'] ?><!--">-->
            <!--                    --><?//endif;?>
            <!--                </div>-->

        </div>
        <script>
            const swiper = new Swiper('.swiper', {
                direction: 'horizontal',
                loop: true,
                speed: 1000,
                slidesPerView: 1,
                spaceBetween: 10,

                breakpoints: {
                    576: {
                        slidesPerView: 1,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    992: {
                        slidesPerView: 4,
                    },
                    1400: {
                        slidesPerView: 6,
                    }
                },

                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },

                autoplay: {
                    delay: 2000
                }
            });
        </script>
    </section>

<?endif;?>


