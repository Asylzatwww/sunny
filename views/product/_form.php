<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use app\models\Catalog;
use app\models\Catalog2;
use app\models\Catalog3;
use app\models\Catalog4;

use app\models\AttributeValue;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

<div class="row deleteImage">
    <?php //if ($model->alias != null) echo "<img src='/upload/" . $model->alias . ".jpg' width='300' />"; 

        $imageCount = array();
        foreach(explode(';', $model->image) as $i => $current){
            if ($current != null) { 

                echo "
  <div class='col-sm-4 col-md-2'>
    <div class='thumbnail'>
      <img src='/upload/product/small/" . $model->alias . $current . ".jpg' alt='" . $model->alias . $current . "'>
      <div class='caption'>
        <p>" . $model->alias . $current . "</p>
      </div>
    </div>
  </div>
";
                $imageCount[$current] = $model->alias . $current;
            }
        } 

    if (!empty($imageCount)) echo $form->field($model, 'deleteImage')->checkboxList($imageCount, [ 'multiple' => true, ]) ?>

</div>


    <?= $form->field($image, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'catalog_id')->dropDownList(
            ArrayHelper::map(Catalog::find()->all(), 'id', 'title'),
            ['prompt' => 'Select catalog']
        ) ?>

        <?= $form->field($model, 'catalog2_id')->dropDownList(
            ArrayHelper::map(Catalog2::find()->all(), 'id', 'title'),
            ['prompt' => 'Select catalog2']
        ) ?>

        <?= $form->field($model, 'catalog3_id')->dropDownList(
            ArrayHelper::map(Catalog3::find()->all(), 'id', 'title'),
            ['prompt' => 'Select catalog3']
        ) ?>

        <?= $form->field($model, 'catalog4_id')->dropDownList(
            ArrayHelper::map(Catalog4::find()->all(), 'id', 'title'),
            ['prompt' => 'Select catalog4']
        ) ?>

    </div>



    <div class="col-md-3">
        <h2>Product attributes</h2>
        <?php 
        $tableToShow = function($model, $table){
            if (($model->catalog != null && $model->catalog->attributeShow->$table == 1) ||
                ($model->catalog2 != null && $model->catalog2->attributeShow->$table == 1) ||
                ($model->catalog3 != null && $model->catalog3->attributeShow->$table == 1) || 
                ($model->catalog4 != null && $model->catalog4->attributeShow->$table == 1)) return true;
        };
        if ($tableToShow($model, 'prize')) echo $form->field($model, 'prize')->textInput(['maxlength' => true]);
        if ($tableToShow($model, 'weight')) echo $form->field($model, 'weight')->textInput(['maxlength' => true]);

        if ($tableToShow($model, 'pol')) echo $form->field($model, 'pol')->dropDownList(
        ArrayHelper::map(AttributeValue::find()->where([ 'attribute_type_id' => 5 ])->all(), 'id', 'title'),
        ['prompt' => 'Select catalog']
        ); 

        if ($tableToShow($model, 'country')) echo $form->field($model, 'country')->dropDownList(
        ArrayHelper::map(AttributeValue::find()->where([ 'attribute_type_id' => 10 ])->all(), 'id', 'title'),
        ['prompt' => 'Select catalog']
        ); 

        if ($tableToShow($model, 'proizvoditel')) echo $form->field($model, 'proizvoditel')->dropDownList(
        ArrayHelper::map(AttributeValue::find()->where([ 'attribute_type_id' => 4 ])->all(), 'id', 'title'),
        ['prompt' => 'Select catalog']
        ); 



        if ($tableToShow($model, 'sezonnost')) echo $form->field($model, 'sezonnost')->dropDownList(
        ArrayHelper::map(AttributeValue::find()->where([ 'attribute_type_id' => 6 ])->all(), 'id', 'title'),
        ['prompt' => 'Select catalog']
        ); 

        if ($tableToShow($model, 'materialout')) echo $form->field($model, 'materialout')->dropDownList(
        ArrayHelper::map(AttributeValue::find()->where([ 'attribute_type_id' => 7 ])->all(), 'id', 'title'),
        ['prompt' => 'Select catalog']
        ); 

        if ($tableToShow($model, 'materialin')) echo $form->field($model, 'materialin')->dropDownList(
        ArrayHelper::map(AttributeValue::find()->where([ 'attribute_type_id' => 8 ])->all(), 'id', 'title'),
        ['prompt' => 'Select catalog']
        ); 

        if ($tableToShow($model, 'category')) echo $form->field($model, 'category')->dropDownList(
        ArrayHelper::map(AttributeValue::find()->where([ 'attribute_type_id' => 9 ])->all(), 'id', 'title'),
        ['prompt' => 'Select catalog']
        ); 

        if ($tableToShow($model, 'color')) echo $form->field($model, 'color')->dropDownList(
        ArrayHelper::map(AttributeValue::find()->where([ 'attribute_type_id' => 11 ])->all(), 'id', 'title'),
        ['prompt' => 'Select catalog']
        ); 


    ?>

    </div>
    <div class="col-md-3">

    </div>
    <div class="col-md-3">

    </div>
</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
