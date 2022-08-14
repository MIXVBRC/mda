<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мебельная компания");
?>

    <section class="slider">
        <div class="slider__list">
            <div class="slider__item">
                <div class="mda-animate">
                    <img class="mda-animate__w" src="<?=SITE_TEMPLATE_PATH?>/img/mda_w.png" alt="">
                    <img class="mda-animate__r" src="<?=SITE_TEMPLATE_PATH?>/img/mda_r.png" alt="">
                    <img class="mda-animate__b" src="<?=SITE_TEMPLATE_PATH?>/img/mda_b.png" alt="">
                </div>
                <div class="slider__description">Сеть магазинов кальянной индустрии</div>
                <img class="slider__img img__contain" src="<?=SITE_TEMPLATE_PATH?>/img/slider.png" alt="">
            </div>
        </div>
    </section>

    <section class="sections-main">
        <div class="container">
            <div class="sections-main__body">
                <div class="sections-main__list">
                    <div class="sections-main__item">
                        <a class="sections-main__link" href="#">Электроники</a>
                    </div>
                    <div class="sections-main__item">
                        <a class="sections-main__link" href="#">Табаки</a>
                    </div>
                </div>
                <div class="sections-main__img">
                    <img class="img__contain" src="img/baba1.png" alt="">
                </div>
            </div>
        </div>
    </section>

    <section class="popular">
        <div class="container">
            <h2 class="popular__title main__title">Популярное</h2>
            <div class="popular__body">
                <div class="popular__list">

                    <div class="popular__item">
                        <a href="#" class="popular__link">
                            <img src="img/element.jpeg" alt="" class="popular__img img__cover">
                            <div class="popular__name">Glitch Sauce Salt Bleach</div>
                        </a>
                    </div>

                    <div class="popular__item">
                        <a href="#" class="popular__link">
                            <img src="img/element.jpeg" alt="" class="popular__img img__cover">
                            <div class="popular__name">Glitch Sauce Salt Bleach</div>
                        </a>
                    </div>

                    <div class="popular__item">
                        <a href="#" class="popular__link">
                            <img src="img/element.jpeg" alt="" class="popular__img img__cover">
                            <div class="popular__name">Glitch Sauce Salt Bleach</div>
                        </a>
                    </div>

                    <div class="popular__item">
                        <a href="#" class="popular__link">
                            <img src="img/element.jpeg" alt="" class="popular__img img__cover">
                            <div class="popular__name">Glitch Sauce Salt Bleach</div>
                        </a>
                    </div>

                </div>
                <div class="popular__right">
                    <img src="img/baba2.png" alt="" class="img__cover">
                </div>
            </div>
        </div>
    </section>

    <section class="news">
        <div class="container">
            <h2 class="news__title main__title">Новости</h2>
            <div class="news__body">
                <div class="news__list">

                    <div class="news__item">
                        <div class="news__name">Lorem</div>
                        <div class="news__description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</div>
                    </div>

                    <div class="news__item">
                        <div class="news__name">Lorem</div>
                        <div class="news__description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</div>
                    </div>

                    <div class="news__item">
                        <div class="news__name">Lorem</div>
                        <div class="news__description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</div>
                    </div>

                </div>

                <div class="news__right">
                    <img src="img/man1.png" alt="">
                </div>

            </div>
        </div>
    </section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>