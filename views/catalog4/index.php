<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Catalog4Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Catalog4s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog4-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Catalog4', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'alias',
            'category3_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
