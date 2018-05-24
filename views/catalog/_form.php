<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Catalog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?php if (isset($attributeShow)) { 
        echo $form->field($attributeShow, 'prize')->checkbox();
        echo $form->field($attributeShow, 'weight')->checkbox();
        echo $form->field($attributeShow, 'country')->checkbox();
        echo $form->field($attributeShow, 'pol')->checkbox();
        echo $form->field($attributeShow, 'proizvoditel')->checkbox();
        //echo $form->field($attributeShow, 'kolichestvo_yader_prosessora')->checkbox();
        echo $form->field($attributeShow, 'sezonnost')->checkbox();
        echo $form->field($attributeShow, 'materialout')->checkbox();
        echo $form->field($attributeShow, 'materialin')->checkbox();
        echo $form->field($attributeShow, 'category')->checkbox();
        echo $form->field($attributeShow, 'color')->checkbox();

        
    } ?>

    <?php if ($model->alias != null) echo "<img src='/upload/". $image->imageRoot . $model->alias . ".jpg' />"; ?>
    <?= $form->field($image, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
