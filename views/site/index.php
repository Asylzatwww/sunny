<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = 'My Yii Application';
$this->registerJs(' $(".sh-menu-btn").remove();$(".sh-menu-modal-lg").remove(); ');
?>


<div class="rows">
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

    <div class="col-md-9">
        <?php /*<div class="inleft">
            <div class="inbox">
                <?= $mainMenu['list2'] ?>
            </div>
        </div>*/?>




<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="/image/slide1.jpg" alt="slide1">
      <div class="carousel-caption">
        image1
      </div>
    </div>
    <div class="item">
      <img src="/image/slide2.jpg" alt="slide2">
      <div class="carousel-caption">
        image2
      </div>
    </div>
    <div class="item">
      <img src="/image/slide3.jpg" alt="slide3">
      <div class="carousel-caption">
        image3
      </div>
    </div>

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

<h1>Новинки</h1>

<div class="row products">

<?php

foreach ($product as $current) {
  echo $this->render('@app/views/catalog/_product', [
            'model' => $current,
            'rootAlias' => 'product',
        ]);
}
 

                ?>

</div>

    </div>
</div>


