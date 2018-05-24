<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\Catalog;

/* @var $this yii\web\View */
/* @var $model app\models\Catalog2 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog2-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?php if (isset($attributeShow)) { 
        echo $form->field($attributeShow, 'prize')->checkbox();
        echo $form->field($attributeShow, 'weight')->checkbox();
        echo $form->field($attributeShow, 'accumulator_value')->checkbox();
        echo $form->field($attributeShow, 'diagonal')->checkbox();
        echo $form->field($attributeShow, 'proizvoditel')->checkbox();
        echo $form->field($attributeShow, 'kolichestvo_yader_prosessora')->checkbox();
    } ?>
    
    <?php if ($model->alias != null) echo "<img src='/upload/" . $image->imageRoot . $model->alias . ".jpg' />"; ?>
    <?= $form->field($image, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'catalog_id')->dropDownList(
    	ArrayHelper::map(Catalog::find()->all(), 'id', 'title'),
    	['prompt' => 'Select catalog']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
