<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\ImageUpload;
use app\models\SimpleImage;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionImgresize()
    {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/product';
        $i = 0;

        if ($handle = opendir($imagePath . '/temporary')) {

            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != ".." && (
                    exif_imagetype($imagePath . '/temporary/' . $entry) == IMAGETYPE_PNG || 
                    exif_imagetype($imagePath . '/temporary/' . $entry) == IMAGETYPE_JPEG) && !file_exists($imagePath . '/small/' . $entry)
                ) {

                    $imageRes = new SimpleImage();
                    $imageRes->load($imagePath . '/temporary/' . $entry);

                    $imageRes->resizeToWidth(500);
                    $imageRes->save($imagePath . '/big/' . $entry);
                    chmod($imagePath . '/big/' . $entry, 0777);

                    $imageRes->resizeToWidth(300);
                    $imageRes->save($imagePath . '/medium/' . $entry);
                    chmod($imagePath . '/medium/' . $entry, 0777);

                    $imageRes->resizeToWidth(150);
                    $imageRes->save($imagePath . '/small/' . $entry);
                    chmod($imagePath . '/small/' . $entry, 0777);

                    echo $entry."<br>";
                    $i++;
                }
                if ($i > 50) break;
            }

            closedir($handle);
        }
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $image = new ImageUpload(); 
        $image->imageRoot = 'product/';

        if ($model->load(Yii::$app->request->post()) && $model->uniqAlias()) {
            
            $image->imageFiles = UploadedFile::getInstances($image, 'imageFiles');
            
            if ($model->catalog_id == null) $model->catalog_id = 0;
            if ($model->catalog2_id == null) $model->catalog2_id = 0;
            if ($model->catalog3_id == null) $model->catalog3_id = 0;
            if ($model->catalog4_id == null) $model->catalog4_id = 0;

            $model->image = $image->uploadMultiple($model->alias, $model->image, 'product');
            $model->date = date('Y-m-d');
            if ($model->save()) return $this->redirect(['view', 'id' => $model->id]);
        } 

        {
            return $this->render('create', [
                'model' => $model,
                'image' => $image,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldAlias = $model->alias;
        $image = new ImageUpload();
        $image->imageRoot = 'product/'; 

        if ($model->load(Yii::$app->request->post()) && $model->uniqAlias()) {
            
            $image->imageFiles = UploadedFile::getInstances($image, 'imageFiles');

            $model->image = $image->uploadMultiple($model->alias, $model->image, 'product', $model->deleteImage, $oldAlias);

            $model->date = date('Y-m-d');
            if ($model->save()) return $this->redirect(['view', 'id' => $model->id]);
        } 

        {   $image->imageRoot = 'product/medium/'; 
            return $this->render('update', [
                'model' => $model,
                'image' => $image,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = Product::findOne($id);
        $root = $_SERVER['DOCUMENT_ROOT'] . '/upload/product/';
        foreach (explode(';', $model->image) as $current){
            if ($current != null){
                if (file_exists($root . 'small/' . $model->alias . $current . '.jpg')) unlink($root . '/small/' . $model->alias . $current . '.jpg');
                if (file_exists($root . 'medium/' . $model->alias . $current . '.jpg')) unlink($root . '/medium/' . $model->alias . $current . '.jpg');
                if (file_exists($root . 'big/' . $model->alias . $current . '.jpg')) unlink($root . '/big/' . $model->alias . $current . '.jpg');
            }
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
