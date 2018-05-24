<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Catalog3 */

$this->title = 'Create Catalog3';
$this->params['breadcrumbs'][] = ['label' => 'Catalog3s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog3-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'image' => $image,
    ]) ?>

</div>
