<?php

namespace app\controllers;

use Yii;
use app\models\Catalog;
use app\models\CatalogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\ImageUpload;
use yii\web\UploadedFile;
use app\models\ProductSearch;

use app\models\AttributeShow;



/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class CatalogController extends Controller
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
     * Lists all Catalog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatalogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Catalog model.
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
     * Creates a new Catalog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('updatePost')){
            $model = new Catalog();
            $image = new ImageUpload();  
            $image->imageRoot = 'catalog/small/';      

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
        } else throw new NotFoundHttpException('You haven\'t permission to enter this page');
    }

    /**
     * Updates an existing Catalog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updatePost')){
            $model = $this->findModel($id);
            $oldAlias = $model->alias;
            $image = new ImageUpload();
            $attributeShow = new AttributeShow();
            $attributeShow = $attributeShow->find()->where(['catalog_id' => $model->id])->one();
            
            $image->imageRoot = 'catalog/small/';

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
        } else throw new NotFoundHttpException('You haven\'t permission to enter this page');
    }

    /**
     * Deletes an existing Catalog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('updatePost')){
            $model = Catalog::findOne($id);

            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/catalog/small/' . $model->alias . '.jpg'))
                unlink($_SERVER['DOCUMENT_ROOT'] . '/upload/catalog/small/' . $model->alias . '.jpg');
            
            $this->findModel($id)->delete();
            $attributeShow = new AttributeShow();                
            $attributeShow->find()->where(['catalog_id'=>$id])->one()->delete();

            return $this->redirect(['index']);

        } else throw new NotFoundHttpException('You haven\'t permission to enter this page');
    }

    /**
     * Finds the Catalog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Catalog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Catalog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionNew(){

        $product = new ProductSearch();
        
        $date=date_create(date("Y-m-d"));
        date_sub($date,date_interval_create_from_date_string("30 days"));
        
        $product->date = date_format($date,"Y-m-d");
        

        $product = $product->search('');

        return $this->render('new-product', [
            'product' => $product,
        ]);
    }

    public function actionBasket(){

        $product = new ProductSearch();
        $productId = null;
        if (isset($_COOKIE['productbasket'])) {
            $productId = explode(';', $_COOKIE['productbasket']);
            $product->productId = $productId;
        } else $product->productId = -1;

        $product = $product->search('');

        return $this->render('basket', [
            'product' => $product,
        ]);
    }

    public function actionSearch(){

        $mainMenu = new Catalog();
        $mainMenu = $mainMenu->mainMenu();

        $catalog = new CatalogSearch();
        $catalogData = $catalog->search(Yii::$app->request->queryParams);

        $catalog2 = new \app\models\Catalog2Search();
        $catalog3 = new \app\models\Catalog3Search();
        $catalog4 = new \app\models\Catalog4Search();
        $product = new ProductSearch(); 

        $query = $catalog2->title = $catalog3->title = $catalog4->title = 
        $product->title = Yii::$app->request->queryParams["CatalogSearch"]["title"];

        $catalog2Data = $catalog2->search(Yii::$app->request->queryParams);

        $catalog3Data = $catalog3->search(Yii::$app->request->queryParams);

        $catalog4Data = $catalog4->search(Yii::$app->request->queryParams);

        $productData = $product->search(Yii::$app->request->queryParams);

        return $this->render('search', [
            'mainMenu' => $mainMenu,
            'catalog' => $catalog,
            'catalogData' => $catalogData,
            'catalog2' => $catalog2,
            'catalog2Data' => $catalog2Data,
            'catalog3' => $catalog3,
            'catalog3Data' => $catalog3Data,
            'catalog4' => $catalog4,
            'catalog4Data' => $catalog4Data,
            'product' => $product,
            'productData' => $productData,
            'query' => $query,
        ]);
    }


    public function actionShow($catalog, $catalog2 = null, $catalog3 = null, $catalog4 = null, $product = null){
        
        $rootAlias = '';
        $breadCrumbs = array();
        
        $root = '';
        
        $model = Catalog::find()->where([ 'alias' => $catalog ])->one(); 
        if ($model !== null) {
            $breadCrumbs[1] = $model->title; $rootAlias .= '/catalogs/' . $model->alias;
            $root = 'catalog';$imageRoot = 'catalog2';
            $rootCatalog = $model;
            

            
            if ($catalog2 != null) {
                
                if (substr($catalog2,0,1) == '@'){ $root = 'product';
                
                    $model = $model->getProducts()->where([ 'alias' => $catalog2 ])->one();
                    if ($model === null) throw new NotFoundHttpException('The requested page does not exist.');
                
                } else 

                {
                    $model = $model->getCatalog2s()->where([ 'alias' => $catalog2 ])->one();
                    if ($model !== null) {
                        $rootAlias .= '/' . $model->alias;$root = 'catalog2';$imageRoot = 'catalog3';
                        $breadCrumbs[2] = $model->title;
                        $rootCatalog = $model;
                    
                        if ($catalog3 != null) {
                            if (substr($catalog3,0,1) == '@'){ $root = 'product';
                            
                                $model = $model->getProducts()->where([ 'alias' => $catalog3 ])->one();
                                if ($model === null) throw new NotFoundHttpException('The requested page does not exist.');

                            } else {

                                $model = $model->getCatalog3s()->where([ 'alias' => $catalog3 ])->one();

                                if ($model !== null) {
                                    $rootAlias .= '/' . $model->alias;$root = 'catalog3';$imageRoot = 'catalog4';
                                    $breadCrumbs[3] = $model->title;
                                    $rootCatalog = $model;
                            
                                    if ($catalog4 != null) {
                            
                                        if (substr($catalog4,0,1) == '@'){ $root = 'product';
                                        
                                            $model = $model->getProducts()->where([ 'alias' => $catalog4 ])->one();
                                            if ($model === null) throw new NotFoundHttpException('The requested page does not exist.');
                                        
                                        } else { 
                                            $model = $model->getCatalog4s()->where([ 'alias' => $catalog4 ])->one();
                                            if ($model !== null) {
                                                $rootAlias .= '/' . $model->alias;$root = 'catalog4';
                                                $breadCrumbs[4] = $model->title;
                                                $rootCatalog = $model;
                                    
                                                if ($product != null) {
                                    
                                                    $model = $model->getProducts()->where([ 'alias' => $product ])->one();
                                                    if ($model !== null) {
                                                        $rootAlias .= '/' . $model->alias;$root = 'product';
                                                    } else throw new NotFoundHttpException('The requested page does not exist.');
                                    
                                                } else 
                                                
                                                {
                                                    $product = $model->getProducts();
                                                    $model = $model->products;
                                                }
                                            } else throw new NotFoundHttpException('The requested page does not exist.');

                                        }
                            
                                    } else 
                                    
                                    {
                                        $product = $model->getProducts();
                                        $model = $model->catalog4s;
                                    }
                                } else throw new NotFoundHttpException('The requested page does not exist.');

                            }
                                
                        } else 
                        
                        {
                            $product = $model->getProducts();
                            $model = $model->catalog3s;
                        }
                    } else throw new NotFoundHttpException('The requested page does not exist.');

                }            
            
            } else 
            
            {
                $product = $model->getProducts();
                $model = $model->catalog2s;
            }
        } else throw new NotFoundHttpException('The requested page does not exist.');

        $mainMenu = new Catalog();
        $mainMenu = $mainMenu->mainMenu();

        if ($root != 'product'){
            $filterFields = array();
            foreach ($product->all() as $current) {
                if ($current->tCountry) $filterFields['country'][ $current->tCountry->id ] = $current->tCountry->title;
                if ($current->tPol) $filterFields['pol'][ $current->tPol->id ] = $current->tPol->title;
                if ($current->tProizvoditel) $filterFields['proizvoditel'][ $current->tProizvoditel->id ] = $current->tProizvoditel->title;
                if ($current->tSezonnost) $filterFields['sezonnost'][ $current->tSezonnost->id ] = $current->tSezonnost->title;
                if ($current->tMaterialout) $filterFields['materialout'][ $current->tMaterialout->id ] = $current->tMaterialout->title;
                if ($current->tMaterialin) $filterFields['materialin'][ $current->tMaterialin->id ] = $current->tMaterialin->title;
                if ($current->tCategory) $filterFields['category'][ $current->tCategory->id ] = $current->tCategory->title;
                if ($current->tColor) $filterFields['color'][ $current->tColor->id ] = $current->tColor->title;
            }

            $productCount = count($product->all());
            if ($productCount > 0) {
                $searchModel = new ProductSearch();
                $searchModel->query = $product;
                $dataProvider = $searchModel->search(Yii::$app->request->post());
            } else {
                $searchModel = null;
                $dataProvider = null;
            }
            return $this->render('product', [
            'model' => $model,
            'rootAlias' => $rootAlias,
            'breadCrumbs' => $breadCrumbs,
            'root' => $root,
            'product' => $product,
            'imageRoot' => $imageRoot,
            'mainMenu' => $mainMenu,
            'rootCatalog' => $rootCatalog->attributeShow,

            'filterFields' => $filterFields,

            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);

        } else {
            return $this->render('product-detail', [
                'model' => $model,
                'rootAlias' => $rootAlias,
                'breadCrumbs' => $breadCrumbs,
                'root' => $root,
                'product' => $product,
                'imageRoot' => $imageRoot,
                'mainMenu' => $mainMenu,
                'rootCatalog' => $rootCatalog->attributeShow,

            ]);

        }


    }


}





        