<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AttributeShow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-show-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'catalog_id')->textInput() ?>

    <?= $form->field($model, 'catalog2_id')->textInput() ?>

    <?= $form->field($model, 'catalog3_id')->textInput() ?>

    <?= $form->field($model, 'catalog4_id')->textInput() ?>

    <?= $form->field($model, 'prize')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
