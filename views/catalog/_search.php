<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\widgets\Pjax;

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogSearch */
/* @var $form yii\widgets\ActiveForm */


    $this->registerJs(
        '$("document").ready(function(){
            $.pjax.defaults.timeout = false;//IMPORTANT
            $("#outajax").on("pjax:end", function() {
            $.pjax.reload({container:"#inajax"});  //Reload GridView
        });
    });

    '
    ); 
?>

<div class="catalog-search">
<?php Pjax::begin(['id' => 'outajax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]);?>
    <?php $form = ActiveForm::begin([
        'action' => ['catalogs/noutbuki-i-planshety/noutbuki'],
        'method' => 'post',
        'options' => [/*'data-pjax' => true,*/ 'onchange'=>"var container = $(this).closest('[data-pjax-container]');    $.pjax.submit(event, container)"]
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

</div>
