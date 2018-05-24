<?php


use yii\widgets\ListView;



/* @var $this yii\web\View */
/* @var $model app\models\Catalog */
$this->title = 'DNS Результаты поиска - ';

?>



            <div class="row products">

                <?= ListView::widget([
                    'dataProvider' => $product,
                    'itemView' => '_basketProduct.php',
                    'summary' => '',
                    'viewParams' => [
                        'fullView' => true,
                        'context' => 'main-page',
                        'rootAlias' => 'product',
                    ],
                ]); 

                ?>
            </div>

