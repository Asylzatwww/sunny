<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Catalog2Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catalog2s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog2-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Catalog2', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'alias',
            'catalog_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
