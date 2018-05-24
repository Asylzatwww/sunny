<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AttributeShowSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-show-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'catalog_id') ?>

    <?= $form->field($model, 'catalog2_id') ?>

    <?= $form->field($model, 'catalog3_id') ?>

    <?= $form->field($model, 'catalog4_id') ?>

    <?php // echo $form->field($model, 'prize') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
