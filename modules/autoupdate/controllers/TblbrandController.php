<?php

namespace app\modules\autoupdate\controllers;
 
use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\autoupdate\models\TblshopSearch;
use app\modules\autoupdate\models\Tblshop;
use app\modules\autoupdate\models\TblBrand;
use app\modules\autoupdate\models\TblBrandSearch;
/**
 * TblBrandController implements the CRUD actions for TblBrand model.
 */
class TblbrandController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all TblBrand models.
     * @return mixed
     */
    public function actionIndex()
    {
 
        $searchModel = new TblBrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
       }
   

    /**
     * Displays a single TblBrand model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
  
        
        return $this->render('view', [
            'model' => $this->findModel($id),
       ]);}
    

    /**
     * Creates a new TblBrand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new TblBrand();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
       ]);}
       
    

    /**
     * Updates an existing TblBrand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
 
        $model =   $this->findModel($id);
$shp=  new ActiveDataProvider([
      'query' => 
        Tblshop::find()
        ->select(['id','code','desk','flag','upd','data_up','brand_grp_id'])
        ->where(['brand_id'=>$id//$model['id']
                ])
         
     //   ->asarray()
        ]);
$searchModel= new TblshopSearch();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(['index']);//return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model, 
            'shp'=>$shp,
            'searchModel'=>$searchModel
        ]);
    }
    
        

    /**
     * Deletes an existing TblBrand model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
  
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * Finds the TblBrand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblBrand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
  
        if (($model = TblBrand::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    }

