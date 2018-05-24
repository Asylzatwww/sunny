<?php

namespace app\controllers;

use Yii;
use app\models\Catalog3;
use app\models\Catalog3Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\ImageUpload;
use yii\web\UploadedFile;

use app\models\AttributeShow;

/**
 * Catalog3Controller implements the CRUD actions for Catalog3 model.
 */
class Catalog3Controller extends Controller
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
     * Lists all Catalog3 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Catalog3Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Catalog3 model.
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
     * Creates a new Catalog3 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Catalog3();
        $image = new ImageUpload(); 
        $image->imageRoot = 'catalog3/small/';

        if ($model->load(Yii::$app->request->post()) && $model->uniqAlias()) {
            
            $image->imageFile = UploadedFile::getInstance($image, 'imageFile');
            
            if ($image->upload($model->alias) && $model->save()) return $this->redirect(['view', 'id' => $model->id]);
        } 

        {
            return $this->render('create', [
                'model' => $model,
                'image' => $image,
            ]);
        }
    }

    /**
     * Updates an existing Catalog3 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldAlias = $model->alias;
        $image = new ImageUpload();

        $attributeShow = new AttributeShow();
        $attributeShow = $attributeShow->find()->where(['catalog3_id' => $model->id])->one();

        $image->imageRoot = 'catalog3/small/'; 

        if ($model->load(Yii::$app->request->post()) && $model->uniqAlias()) {
            
            $image->imageFile = UploadedFile::getInstance($image, 'imageFile');

            $attributeShow->load(Yii::$app->request->post());
            $attributeShow->update();
            
            if ($image->imageFile != null) $image->upload($model->alias, $oldAlias);
            else $image->aliasRename($oldAlias, $model->alias);

            if ($model->save()) return $this->redirect(['view', 'id' => $model->id]);
        } 

        {
            return $this->render('update', [
                'model' => $model,
                'image' => $image,
                'attributeShow' => $attributeShow,
            ]);
        }
    }

    /**
     * Deletes an existing Catalog3 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = Catalog3::findOne($id);

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/catalog3/small/' . $model->alias . '.jpg'))
            unlink($_SERVER['DOCUMENT_ROOT'] . '/upload/catalog3/small/' . $model->alias . '.jpg');

        $this->findModel($id)->delete();

        $attributeShow = new AttributeShow();                
        $attributeShow->find()->where(['catalog3_id'=>$id])->one()->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Catalog3 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Catalog3 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Catalog3::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
