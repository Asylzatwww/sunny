<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Catalog2 */

$this->title = 'Create Catalog2';
$this->params['breadcrumbs'][] = ['label' => 'Catalog2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog2-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'image' => $image,
    ]) ?>

</div>
