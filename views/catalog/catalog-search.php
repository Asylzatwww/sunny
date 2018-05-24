<?php
use yii\helpers\Html;

if ($rootAlias == 'catalog2'){
	$rootAlias = '/' . $model->catalog->alias;
} else
if ($rootAlias == 'catalog3'){
	$rootAlias = '/' . $model->catalog2->catalog->alias . '/' . $model->catalog2->alias;
} else
if ($rootAlias == 'catalog4'){
	$rootAlias = '/' . $model->category3->catalog2->catalog->alias . '/' . $model->category3->catalog2->alias . '/' . $model->category3->alias;
}

?>




			
				<div><a href='/catalogs<?= $rootAlias . '/' . Html::encode($model->alias) ?>'><?= Html::encode($model->title) ?></a></div>
			
   

