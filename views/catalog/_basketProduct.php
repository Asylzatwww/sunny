<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$image = explode(';', $model->image);

if ($rootAlias == 'product'){
	if ($model->catalog_id != 0) $rootAlias = '/catalogs/' . $model->catalog->alias; else
	if ($model->catalog2_id != 0) $rootAlias = '/catalogs/' . $model->catalog2->catalog->alias . '/' . $model->catalog2->alias; else
	if ($model->catalog3_id != 0) $rootAlias = '/catalogs/' . $model->catalog3->catalog2->catalog->alias . '/' . $model->catalog3->catalog2->alias . '/' . 
		$model->catalog3->alias; else
	if ($model->catalog4_id != 0) $rootAlias = '/catalogs/' . $model->catalog4->category3->catalog2->catalog->alias . '/' . $model->catalog4->category3->catalog2->alias . '/' . 
		$model->catalog4->category3->alias . '/' . $model->catalog4->alias;
}
?>




	<div class='product'>
		<div class='pr-height'>
			<a href='<?= $rootAlias . '/' . Html::encode($model->alias) ?>'>
				<img class='image-responsible' src='/upload/product/small/<?php echo $model->alias; if (isset($image[1])) echo $image[1]; ?>.jpg' />
				<h3><?= Html::encode($model->title) ?></h3>
			</a>
			<div class="prize"><?= Html::encode($model->prize) ?> $</div>
		</div>
		<div class="btn btn-default basketAdd"><input type="hidden" value="<?= Html::encode($model->id) ?>" /><span class="glyphicon glyphicon-remove"></span></div>


	</div>
   

    <?php //echo HtmlPurifier::process($model->text) ?>    