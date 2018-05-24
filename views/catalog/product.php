<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\grid\GridView;

use yii\widgets\Pjax;

use yii\widgets\ActiveForm;

use yii\widgets\ListView;

use app\models\Catalog;

use yii\widgets\Breadcrumbs;

use yii\helpers\ArrayHelper;

use app\models\AttributeValue;



/* @var $this yii\web\View */
/* @var $model app\models\Catalog */





$breadcrumbsarr = explode('/', $rootAlias);
$breadcrumbsurl = $breadcrumbsarr[1];

for ($i = 2; $i < count($breadcrumbsarr); $i++){ $breadcrumbsurl .=  '/' . $breadcrumbsarr[$i];
    if (isset($breadcrumbsarr[$i])) $this->params['breadcrumbs'][] = ['label' => $breadCrumbs[$i-1], 'url' => [ $breadcrumbsurl ]];
}

$list = '';

foreach($model as $current){
    $list .= "
    <div class='catalog'>
        <a href='" . $rootAlias . '/' . $current->alias . "'>
            <img class='image-responsible' src='/upload/" . $imageRoot . '/small/' . $current->alias . ".jpg' />
            <h3>" . $current->title . "</h3>
        </a>
    </div>";
}   

$this->title = 'DNS ' . end($breadCrumbs);



$this->registerJsFile('/js/bootstrap-slider.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile('/css/slider.css');

$this->registerJs('

function prizeSlide(){
    $("#prizeSlide").slider({
        tooltip : "hide",
    });
    $("#prizeSlide").on("slide", function(slideEvt) {
        $("#productsearch-prizefrom").val(slideEvt.value[0]);
        $("#productsearch-prizeto").val(slideEvt.value[1]);
        $("#prize-btn").fadeIn();
    });

}

prizeSlide();

var searchGroupHideArray = Array();

function searchGroupHide(){

    $("#searchResultPjax .form-group .control-label").each(function(index){
        if ($(this).parent().find("div").hasClass("prCheckboxList")) {

            $(window).scrollTop(pageScroll);
            
            $(this).css({ cursor : "pointer", position : "relative" });
            
            $(this).parent().css({ margin: "-6px -15px 0px", padding: "6px 15px 15px", });

            if (searchGroupHideArray.indexOf(index) > -1){
                $(this).html("<p style=\"width:200px\">" + $(this).html() + "</p><span class=\"glyphicon glyphicon-menu-up\" style=\"position:absolute;right:5px\"></span>");
            } else {
                $(this).html("<p style=\"width:200px\">" + $(this).html() + "</p><span class=\"glyphicon glyphicon-menu-down\" style=\"position:absolute;right:5px\"></span>");
                $(this).parent().find("div").hide();
            }
        } 
    });
    $("#searchResultPjax .form-group .control-label").click(function(){
        if ($(this).find("span").hasClass("glyphicon-menu-up")){
            $(this).find("span").removeClass("glyphicon-menu-up");
            $(this).find("span").addClass("glyphicon-menu-down");
            $(this).parent().find("div").slideUp(500);
            
            searchGroupHideArray.splice(searchGroupHideArray.indexOf($("#searchResultPjax .form-group .control-label").index(this)),1);
        } else {
            $(this).find("span").removeClass("glyphicon-menu-down");
            $(this).find("span").addClass("glyphicon-menu-up");
            $(this).parent().find("div").slideDown(500);
            searchGroupHideArray.push($("#searchResultPjax .form-group .control-label").index(this));
        }
        console.log(searchGroupHideArray);
    });
}


searchGroupHide();

$("document").ready(function(){

        $("#searchResultPjax").on("pjax:end", function() {
            prizeSlide();searchGroupHide();
        });

        $(".sh-menu-modal-lg").on("show.bs.modal", function (e) {
            
            var shNavbar = 0;
            if (!$(".sh-navbar-fixed").hasClass("navbar-fixed-top")) { shNavbar = $(".sh-navbar-fixed").offset();shNavbar = shNavbar.top; }
            shNavbar +=  $(".sh-navbar-fixed").height();
            $(".menu-modal-lg").css({ marginTop : shNavbar });
            $(".sh-menu-btn").addClass("glyphicon-menu-up").removeClass("glyphicon-menu-down");
        })
        $(".sh-menu-modal-lg").on("shown.bs.modal", function (e) {
            $(".inbox").css({ minHeight : $(".menu").height() });
        });
        $(".sh-menu-modal-lg").on("hidden.bs.modal", function (e) {
            $(".sh-menu-btn").addClass("glyphicon-menu-down").removeClass("glyphicon-menu-up");
        });

        $(".menu-modal-lg").find(".row").on("click", function(e) {
          if (e.target !== this)
            return;

          $(".sh-menu-modal-lg").modal("hide")
        });
    });

    ');


?>

<div class="rows sh-product">

    <div class="col-md-3"></div>
    <div class="col-md-9">
        <?= Breadcrumbs::widget([
                    'homeLink'=>[ 'label' => 'Главная', 'url' => '/', ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
    </div>

    <?php if ($dataProvider != null) { ?>


    <?php Pjax::begin(['id' => 'searchResultPjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]);?>

    <div class="col-md-3" style="margin-top: -60px;">

        <div class="thumbnail">

        <?php $form = ActiveForm::begin([
            'action' => [$breadcrumbsurl],
            'method' => 'post',
            'options' => ['onchange'=>" var container = $(this).closest('[data-pjax-container]');  $.pjax.submit(event, container);  "]
        ]); ?>


        <?php if ($rootCatalog->prize == 1) { 
                echo $form->field($searchModel, 'prizeFrom')->textInput([ 'class' => 'doubleInput1' ]) .
                    $form->field($searchModel, 'prizeTo')->textInput([ 'class' => 'doubleInput2' ])->label(false) . "
        
            <input id='prizeSlide'  type='text' data-slider-min='0' data-slider-max='60000' data-slider-step='1000' data-slider-value='[" . $searchModel->prizeFrom .
            "," . $searchModel->prizeTo . "]'/>" . 
            "<div class='form-group' style='display:none;'' id='prize-btn'>" . Html::submitButton('Search', ['class' => 'btn btn-primary']) . "</div><hr>";
            }

            if ($rootCatalog->pol == 1 && isset($filterFields['pol']) && count($filterFields['pol']) > 1) echo $form->field($searchModel, 'pol',
                [ 'options'=>[ 'class' => ($searchModel->pol)?('form-group prCheckBorder'):('form-group') ] ]
                )->checkboxList( $filterFields['pol'], [ 'multiple' => true, 'class' => 'prCheckboxList' ]) . '<hr>';

            if ($rootCatalog->country == 1 && isset($filterFields['country']) && count($filterFields['country']) > 1) echo $form->field($searchModel, 'country',
                [ 'options'=>[ 'class' => ($searchModel->country)?('form-group prCheckBorder'):('form-group') ] ]
                )->checkboxList( $filterFields['country'], [ 'multiple' => true, 'class' => 'prCheckboxList' ]) . '<hr>';

            if ($rootCatalog->proizvoditel == 1 && isset($filterFields['proizvoditel']) && count($filterFields['proizvoditel']) > 1) echo $form->field($searchModel, 'proizvoditel',
                [ 'options'=>[ 'class' => ($searchModel->proizvoditel)?('form-group prCheckBorder'):('form-group') ] ]
                )->checkboxList( $filterFields['proizvoditel'], [ 'multiple' => true, 'class' => 'prCheckboxList' ]) . '<hr>';

            if ($rootCatalog->sezonnost == 1 && isset($filterFields['sezonnost']) && count($filterFields['sezonnost']) > 1) echo $form->field($searchModel, 'sezonnost',
                [ 'options'=>[ 'class' => ($searchModel->sezonnost)?('form-group prCheckBorder'):('form-group') ] ]
                )->checkboxList( $filterFields['sezonnost'], [ 'multiple' => true, 'class' => 'prCheckboxList' ]) . '<hr>';

            if ($rootCatalog->materialout == 1 && isset($filterFields['materialout']) && count($filterFields['materialout']) > 1) echo $form->field($searchModel, 'materialout',
                [ 'options'=>[ 'class' => ($searchModel->materialout)?('form-group prCheckBorder'):('form-group') ] ]
                )->checkboxList( $filterFields['materialout'], [ 'multiple' => true, 'class' => 'prCheckboxList' ]) . '<hr>';

            if ($rootCatalog->materialin == 1 && isset($filterFields['materialin']) && count($filterFields['materialin']) > 1) echo $form->field($searchModel, 'materialin',
                [ 'options'=>[ 'class' => ($searchModel->materialin)?('form-group prCheckBorder'):('form-group') ] ]
                )->checkboxList( $filterFields['materialin'], [ 'multiple' => true, 'class' => 'prCheckboxList' ]) . '<hr>';

            if ($rootCatalog->category == 1 && isset($filterFields['category']) && count($filterFields['category']) > 1) echo $form->field($searchModel, 'category',
                [ 'options'=>[ 'class' => ($searchModel->category)?('form-group prCheckBorder'):('form-group') ] ]
                )->checkboxList( $filterFields['category'], [ 'multiple' => true, 'class' => 'prCheckboxList' ]) . '<hr>';

            if ($rootCatalog->color == 1 && isset($filterFields['color']) && count($filterFields['color']) > 1) echo $form->field($searchModel, 'color',
                [ 'options'=>[ 'class' => ($searchModel->color)?('form-group prCheckBorder'):('form-group') ] ]
                )->checkboxList( $filterFields['color'], [ 'multiple' => true, 'class' => 'prCheckboxList' ]) . '<hr>';

        ?>

        <?php ActiveForm::end(); ?>

    </div>

    </div>

    <div class="col-md-9">


        <div class="row catalogs">

            <?= $list; ?>
        </div>

            <h1>Есть в наличий</h1>

            <div class="row products">

                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_product',
                    'summary' => '',
                    'viewParams' => [
                        'fullView' => true,
                        'context' => 'main-page',
                        'rootAlias' => $rootAlias,
                    ],
                    'emptyText' => '',
                ]); 

                ?>
            </div>

    </div>

    <?php Pjax::end(); } else { $this->registerJs(' $(".sh-menu-btn").remove();$(".sh-menu-modal-lg").remove(); '); ?>


        <div class="col-md-3" style="margin-top: -60px;">

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


    <div class="col-md-9">
            <?php /*<div class="inleft" style="margin-top: -60px;">
                <div class="inbox">
                    <?= $mainMenu['list2'] ?>
                </div>
            </div>*/?>


        <div class="row catalogs" style="margin-top: 60px;">


            <?= $list; ?>
        </div>

    </div>

    <?php } ?>


</div>







