<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;


use yii\widgets\ActiveForm;

use app\models\CatalogSearch;
use yii\helpers\Url;

use yii\widgets\Breadcrumbs;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="/favicon.png" type="image/png">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-default sh-navbar',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            "<li><a><span class='glyphicon glyphicon-earphone'></span>  8-499-704-46-40</a></li>",
            ['label' => 'Контакты', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/site/login']]
            ) : (
                '
<ul class="navbar-nav navbar-left nav">
        

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-user"></span>
            <span class="caret"></span>
        </a>
          <ul class="dropdown-menu">
            <li><a href="/site/profile">Профиль ' . Yii::$app->user->identity->username . '</a></li>
            <li role="separator" class="divider"></li>
            <li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                ) 
                . Html::endForm() . '</li>
          </ul>
        </li>
        
    </ul>
                '
            ),
            Yii::$app->user->isGuest ? (
                        ['label' => 'Регистрация', 'url' => ['site/signup']]
                    ) : ( '' ),
        ],
    ]);


?>

    




    
    <ul class="navbar-nav navbar-left nav">
        <li><a href="/site/about">О компании</a></li>
        <li><a href="/site/about">Реквизиты</a></li>
        <li><a href="/site/about">Отзывы и пожелания</a></li>
        <li><a href="/site/about">Доставка</a></li>
        <li><a href="/site/about">Возврат</a></li>        
    </ul>

<?php if (\Yii::$app->user->can('updatePost')) { ?>
    <ul class="navbar-nav navbar-left nav">
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Edit <span class="caret"></span></a>
              <?= Nav::widget([
            'options' => ['class' => 'dropdown-menu'],
            'items' => [
                ['label' => 'Catalog', 'url' => ['/catalog']],
                ['label' => 'Catalog2', 'url' => ['/catalog2']],
                ['label' => 'Catalog3', 'url' => ['/catalog3']],
                ['label' => 'Catalog4', 'url' => ['/catalog4']],
                ['label' => 'Product', 'url' => ['/product']],
                ['label' => 'AttributeType', 'url' => ['/attribute-type']],
                ['label' => 'AttributeValue', 'url' => ['/attribute-value']],
            ],
            ]);?>
        </li>
        
    </ul>
<?php } ?>


<?php
    NavBar::end();

    $this->registerJs("
        $('.scrollTop').click(function(){
            $('body,html').animate({ scrollTop : 0 }, 500);
        });

        var bodyHeight = document.body.scrollHeight, pageScroll = 0;
        window.onscroll = function(){ 
            pageScroll = $(window).scrollTop();
            var shNavbar = $('.sh-navbar').offset();
            shNavbar = shNavbar.top + $('.sh-navbar').height();
            if ($(window).scrollTop() > 100) $('.scrollTop').show(); else $('.scrollTop').hide();
            if ($(window).scrollTop() > shNavbar && bodyHeight > window.innerHeight + shNavbar +100) { 
                $('.sh-navbar-fixed').addClass('navbar-fixed-top');
                $('.sh-navbar').css({ marginBottom : $('.sh-navbar-fixed').height() });
            } else { 
                $('.sh-navbar-fixed').removeClass('navbar-fixed-top');
                $('.sh-navbar').css({ marginBottom : 0 });
            }
        }

    /* here goes menu */
    var selList = '';
    $('.inbox').css({ minHeight : $('.menu').height() });
    
    for (var i=1;i<" . \app\models\Catalog::find()->count() . "+1;i++){
        $('.list' + i).mouseover(function(){
            $('.inbox div').hide();
            selList = '.' + $(this).attr('class');
            $('.inbox .i' + $(this).attr('class')).show();
        });
    }
    
    $('.inleft').mouseout(function(){
        $('.inbox').hide();
        $('.menu li').removeClass('listSel');
        $('.menu li:first-child').css({ borderRadius: '3px 3px 0px 0px' });
    });
    
    $('.inleft').mouseover(function(){
        $('.inbox').show();
        $('.menu li:first-child').css({ borderRadius: '3px 0px 0px 0px' });
        $('.menu li').removeClass('listSel');
        $(selList).addClass('listSel');
    });
    
    /* menu ends up */

    /* here goes add product to basket */


function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = '; expires=' + date.toGMTString();
    } else {
        expires = '';
    }
    document.cookie = encodeURIComponent(name) + '=' + encodeURIComponent(value) + expires + '; path=/';
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + '=';
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, '', -1);
}

    //eraseCookie('productbasket');eraseCookie('productbasketprize');
        if (readCookie('productbasket') != null){
        var arr = readCookie('productbasket').split(';');//.splice('13');
        var arr1 = Array();

        console.log(arr.splice(arr.indexOf('13')));//join(';'));

    }
        console.log(readCookie('productbasket'));

        $('.basketAdd').click(function(){  
            if ($(this).hasClass('basketAdd') == true){
                var productbasket = '';
                var productId = $(this).find('input').val();
                
                if (readCookie('productbasket')!=null) { 
                    productbasket = readCookie('productbasket'); 
                    productbasketprize = parseFloat(readCookie('productbasketprize')); 

                    var arrBasket = readCookie('productbasket').split(';');
                    if (arrBasket.indexOf(productId) > -1){
                        arrBasket.splice(arrBasket.indexOf(productId),1);
                        productbasketprize -= parseFloat($(this).parent().find('.prize').html());
                        createCookie('productbasketprize', productbasketprize, 2);
                        $(this).parent().remove();
                        createCookie('productbasket', arrBasket.join(';'), 2);console.log('del - ' + productId);
                        if (productbasketprize > 0) $('.productbasketprize').html(productbasketprize); else  $('.productbasketprize').html('Корзина');
                    } else {
                        productbasket += ';' + productId;
                        productbasketprize += parseFloat($(this).parent().find('.prize').html());
                        createCookie('productbasketprize', productbasketprize, 2);
                        createCookie('productbasket', productbasket, 2);console.log('add - ' + productId);
                        $(this).removeClass('basketAdd').html('<a href=\'/catalog/basket\'>В корзине</a>');
                        $('.productbasketprize').html(productbasketprize);
                    }

                } else {
                    createCookie('productbasketprize', parseFloat($(this).parent().find('.prize').html()), 2);
                    createCookie('productbasket', ';' + productId, 2);console.log('new - ' + productId);
                    $(this).removeClass('basketAdd').html('<a href=\'/catalog/basket\'>В корзине</a>');
                    $('.productbasketprize').html(parseFloat($(this).parent().find('.prize').html()));
                }
            }
        }); 

    /* add product to basket ends up here */

        ");


    ?>





<nav class="navbar navbar-default sh-navbar-fixed">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">Sunny</a>
      <button type="button" class="sh-menu-btn btn btn-primary glyphicon glyphicon-menu-down" data-toggle="modal" data-target=".sh-menu-modal-lg"></button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form class="navbar-form navbar-left" role="search">
            <div class="input-group sh-input-group-lg">


    <?php $form = ActiveForm::begin(); ?>

    <?php ActiveForm::end(); ?>



                <?php 
                $model = new CatalogSearch();
                $form = ActiveForm::begin([
                    'action' => Url::to(['catalog/search']),
                    'method' => 'get',
                    'class' => 'input-group sh-input-group-lg',
                ]); ?>


                <span class="input-group-btn">
                <?= $form->field($model, 'title')->label(false) ?>
                    <?= Html::submitButton('Поиск', ['class' => 'btn btn-default']) ?>
                </span>

                <?php ActiveForm::end(); ?>



            </div><!-- /input-group -->
      </form>
        <ul class="nav navbar-nav">
            <li>
                <a href="/catalog/basket" style="padding: 0px;"><button class="btn btn-default sh-button " type="submit">
                    <span class="glyphicon glyphicon-shopping-cart"></span> <span class="productbasketprize"> &nbsp;
                    <?php if (isset($_COOKIE['productbasketprize']) && $_COOKIE['productbasketprize'] != '0') 
                    echo $_COOKIE['productbasketprize']; else echo 'Корзина'; ?></span></button>
                </a>
            </li>
        </ul>
      

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<?php

$mainMenu = new \app\models\Catalog();
        $mainMenu = $mainMenu->mainMenu();

?>

    <div class="modal fade sh-menu-modal-lg" style="left:0px;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog menu-modal-lg">


        <div class="row">
            <div class="col-md-3">

                <div class="left">
                    <div class="inleft">
                        <div>   
                            <ul class="menu">
                                <li>Меню</li>
                                <?= $mainMenu['list1'] ?>

                            </ul>
                        </div>
                        
                    </div>
                    <a href="/catalog/new" class="btn btn-default sh-button sh-buttonBlue" type="submit" >Все Новинки</a>
                </div>

            </div>
            <?php /*<div class="col-md-9">

                <div class="inleft">
                    <div class="inbox">
                        <?= $mainMenu['list2'] ?>
                    </div>
                </div>

            </div>*/ ?>

        </div>


      </div>
    </div>





    <div class="container">
        
        <?php if (strpos(Url::to(''), 'catalogs') == 0) echo Breadcrumbs::widget([
                    'homeLink'=>[ 'label' => 'Главная', 'url' => '/', ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>                
                <?= $content ?>

        <div class="scrollTop"><span class="glyphicon glyphicon-menu-up"></span></div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        
        <div class="row">
            <div class="col-md-3">
                <h3>Компания</h3>
                <p><a href="/site/about">О компании</a></p>
            </div>
            <div class="col-md-3">
                <h3>Покупателям</h3>


            <p><a href="/site/about">Бонусная программа</a></p>
            <p><a href="/site/about">Доставка</a></p>
            <p><a href="/site/about">Способы оплаты</a></p>
            <p><a href="/site/about">Кредиты</a></p>
            <p><a href="/site/about">Услуги</a></p>
            <p><a href="/site/about">Информация для юр. лиц</a></p>
            <p><a href="/site/about">Сервисные центры</a></p>
            <p><a href="/site/about">Проверка оплаты счёта</a></p>
            <p><a href="/site/about">Статус оборудования СЦ</a></p>



            </div>
            <div class="col-md-3"></div>
            <div class="col-md-3"></div>
        </div>
        <hr>
        <p> Информация, указанная на сайте, не является публичной офертой. Информация о товарах, их технических свойствах и характеристиках, 
            ценах является предложением Sunny делать оферты. Акцептом Sunny полученной оферты является подтверждение заказа с указанием товара и его цены. 
            Сообщение Sunny о цене заказанного товара, отличающейся от указанной в оферте, является отказом Sunny от акцепта и одновременно офертой со стороны Sunny. 
            Информация о технических характеристиках товаров, указанная на сайте, может быть изменена производителем в одностороннем порядке. 
            Изображения товаров на фотографиях, представленных в каталоге на сайте, могут отличаться от оригиналов. Информация о цене товара, 
            указанная в каталоге на сайте, может отличаться от фактической к моменту оформления заказа на соответствующий товар. 
            Подтверждением цены заказанного товара является сообщение Sunny о цене такого товара. </p>
        <hr>

        <p style="margin-bottom:30px;">© 2016—<?= date('Y') ?> Компания Sunny</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
