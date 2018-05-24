<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AttributeShowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attribute Shows';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-show-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Attribute Show', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'catalog_id',
            'catalog2_id',
            'catalog3_id',
            'catalog4_id',
            // 'prize',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
