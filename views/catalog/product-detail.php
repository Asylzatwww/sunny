<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

use yii\widgets\Breadcrumbs;

use app\models\AttributeValue;


$breadcrumbsarr = explode('/', $rootAlias);
$breadcrumbsurl = $breadcrumbsarr[1];

for ($i = 2; $i < count($breadcrumbsarr); $i++){ $breadcrumbsurl .=  '/' . $breadcrumbsarr[$i];
    if (isset($breadcrumbsarr[$i])) $this->params['breadcrumbs'][] = ['label' => $breadCrumbs[$i-1], 'url' => [ $breadcrumbsurl ]];
}

$this->params['breadcrumbs'][] = $model->title;
$this->title = 'DNS ' . $model->title;

$carousel = array();$i=0;
$carousel[1] = '';
$carousel[2] = '';

foreach(explode(';', $model->image) as $current){
    if ($current != null) {
    	
    	$carousel[1] .= "<li data-target='#carousel-example-generic' data-slide-to='" . $i . "' " . (($i == 0) ? ( " class='active'" ) : ( "" )) . "></li>";
    	$carousel[2] .= "
		    <div class='item  " . (($i == 0) ? ( " active" ) : ( "" )) . "'>
		      <img src='/upload/product/big/" . $model->alias . $current . ".jpg' alt='" . $model->title . " image - " . $current . "'>
		      <div class='carousel-caption'>
		        <div>image - " . $current . "</div>
		      </div>
		    </div>
		";

    	$i++;
    }
}


?>

<?= Breadcrumbs::widget([
                    'homeLink'=>[ 'label' => 'Главная', 'url' => '/', ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>


<h1><?= $model->title ?></h1>
<p style="font-size: 16px;color: #B3B3B3;">Код товара <?= $model->id ?></p>

<div class="product-detailed">

  <div class="row">
    <div class="col-md-4">
      <div id="carousel-example-generic" class="carousel slide sh-product-slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <?= $carousel[1] ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <?= $carousel[2] ?>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    <div class="col-md-8">
      <p class="prize"><?= $model->prize ?> Р</p>
      <p>
        <button type="button" class="btn btn-lg btn-cart">Warning</button>
      </p>
      <p>
        <button type="button" class="btn btn-lg btn-compare btn-default glyphicon glyphicon-stats"></button>
        <button type="button" class="btn btn-lg btn-primary btn-message glyphicon glyphicon-envelope"></button>
      </p>
    </div>
  </div>

</div>



<div class="product-description">

  <!-- Nav tabs -->
  <div class="property-tab">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Описание</a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Отзывы</a></li>
      <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Комментарии</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="home">
        <h3>Описание <?= $model->title ?></h3>
        <?= $model->description ?>
        <h3>Характеристики <?= $model->title ?></h3>

        <div class="product-property">

          <div>Общие параметры</div>
          <?php 
              if ($rootCatalog->country == 1 && $model->tCountry) echo '<div><span>Страна</span><span>' . $model->tCountry->title . '</span></div>';
              if ($rootCatalog->proizvoditel == 1 && $model->tProizvoditel) echo '<div><span>Производитель</span><span>' . $model->tProizvoditel->title . '</span></div>';
              if ($rootCatalog->pol == 1 && $model->tPol) echo '<div><span>Пол</span><span>' . $model->tPol->title . '</span></div>';
              if ($rootCatalog->sezonnost == 1 && $model->tSezonnost) echo '<div><span>Сезонность</span><span>' . $model->tSezonnost->title . '</span></div>';
              if ($rootCatalog->materialout == 1 && $model->tMaterialout) echo '<div><span>Материал внешний</span><span>' . $model->tMaterialout->title . '</span></div>';
              if ($rootCatalog->materialin == 1 && $model->tMaterialin) echo '<div><span>Материал внутренний</span><span>' . $model->tMaterialin->title . '</span></div>';
              if ($rootCatalog->category == 1 && $model->tCategory) echo '<div><span>Категория</span><span>' . $model->tCategory->title . '</span></div>';
              if ($rootCatalog->color == 1 && $model->tColor) echo '<div><span>Цвет</span><span>' . $model->tColor->title . '</span></div>';
          ?>

        </div>

      </div>
      <div role="tabpanel" class="tab-pane" id="profile">...</div>
      <div role="tabpanel" class="tab-pane" id="messages">...</div>
    </div>
  </div>

</div>








<?= Breadcrumbs::widget([
                    'homeLink'=>[ 'label' => 'Главная', 'url' => '/', ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>




