<?php

use yii\helpers\Html;



use yii\widgets\ActiveForm;

use yii\widgets\ListView;



/* @var $this yii\web\View */
/* @var $model app\models\Catalog */
$this->title = 'DNS Результаты поиска - ' . $query;

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
            <input class="btn btn-default sh-button sh-buttonBlue" type="submit" value="Submit">
        </div>

    </div>



    <div class="col-md-9">
        <div class="inleft">
            <div class="inbox">
                <?= $mainMenu['list2'] ?>
            </div>
        </div>
        <h3>Результаты поиска - <?= $query ?><h3>
            <h3>В категориях</h3>

            <div>

                <?= ListView::widget([
                    'dataProvider' => $catalogData,
                    'itemView' => 'catalog-search',
                    'summary' => '',
                    'viewParams' => [
                        'fullView' => true,
                        'context' => 'main-page',
                        'rootAlias' => '',
                    ],
                    'emptyText' => '',
                ]); 

                ?>
                <br>

                <?= ListView::widget([
                    'dataProvider' => $catalog2Data,
                    'itemView' => 'catalog-search',
                    'summary' => '',
                    'viewParams' => [
                        'fullView' => true,
                        'context' => 'main-page',
                        'rootAlias' => 'catalog2',
                    ],
                    'emptyText' => '',
                ]); 

                ?>
                <br>

                <?= ListView::widget([
                    'dataProvider' => $catalog3Data,
                    'itemView' => 'catalog-search',
                    'summary' => '',
                    'viewParams' => [
                        'fullView' => true,
                        'context' => 'main-page',
                        'rootAlias' => 'catalog3',
                    ],
                    'emptyText' => '',
                ]); 

                ?>
                <br>

                <?= ListView::widget([
                    'dataProvider' => $catalog4Data,
                    'itemView' => 'catalog-search',
                    'summary' => '',
                    'viewParams' => [
                        'fullView' => true,
                        'context' => 'main-page',
                        'rootAlias' => 'catalog4',
                    ],
                    'emptyText' => '',
                ]); 

                ?>
            </div>


            <h1>Есть в наличий</h1>

            <div class="row products">

                <?= ListView::widget([
                    'dataProvider' => $productData,
                    'itemView' => '_product',
                    'summary' => '',
                    'viewParams' => [
                        'fullView' => true,
                        'context' => 'main-page',
                        'rootAlias' => 'product',
                    ],
                    'emptyText' => 'По Вашему запросу ничего не найдено.',
                ]); 

                ?>
            </div>

    </div>


</div>