<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Catalog4 */

$this->title = 'Create Catalog4';
$this->params['breadcrumbs'][] = ['label' => 'Catalog4s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog4-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'image' => $image,
    ]) ?>

</div>
