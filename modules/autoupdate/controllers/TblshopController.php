<?php

namespace app\modules\autoupdate\controllers;
use yii\rest\ActiveController;
use Yii;
use app\modules\autoupdate\models\Tblshop;
use app\modules\autoupdate\models\TblshopSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\autoupdate\models\TblGroup;
use app\modules\autoupdate\models\TblBrand;
use yii\helpers\Json;
use yii\web\Response;
use app\modules\autoupdate\models\Rlsbrdshp;

/**
 * TblshopController implements the CRUD actions for Tblshop model.
 */
class TblshopController extends Controller
{
   // public $modelClass = 'app\models\Tblshop';
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
     * Lists all Tblshop models.
     * @return mixed
     */
    public function actionIndex()
    {
         
      //  \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $searchModel = new TblshopSearch();
        $dataProvider =  $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tblshop model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tblshop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       
        $model = new Tblshop();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $rel= new Rlsbrdshp();
                    $rel->setAttribute('brand_id',$model['brand_id']);
                      $rel->setAttribute('shop_id',$model['id']);
                      $rel->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tblshop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
       
        $model = $this->findModel($id);

         $session = Yii::$app->session;
         
        
        if ($model->load(Yii::$app->request->post())&& $model->save()    ) {
            $session->set('brand_grp_id', $model['brand_grp_id']); 
            $session->set('modello',$model);
            if ($model['brand_grp_id']==null ||$model['brand_grp_id']='')
        {
           $model->setAttribute('brand_grp_id',0); 
           $model->save();
        }
            
            $this->redirect(['index']);//return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tblshop model.
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
    
    public function actionPath($id,$brand,$type)
    {
        
        if ($type='j'){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        }
        $model=tblshop::find()
                ->where(['code'=>$id])
                ->andwhere(['brand_id'=>$brand])
                ->one();
   
        if ($model['flag']=1)
        {
            if (isset($model['spec_path'])   ) { 
        return $model['spec_path'];
            
            } else 
        {
        return "non ho trovato dati la dir è vuota ed è attivo sul negozio";    
        }
        }
        else
        {
         $gmodel= TblGroup::find()
                    ->where(['id'=>$model['brand_grp_id']])
                    ->one();
            if ($gmodel['flag']=1) {
             if (isset($godel['spec_path'])   ) { 
                return $gmodel['grp_path'];
             }
             else
             {
                 return "non ho trovato dati la dir è vuota ed è attivo sul gruppo"; 
                 
             }
            }
            else {
            $bmodel= TblBrand::find()
                    ->where(['id'=>$brand])
                    ->one();
                return $bmodel['defa_path'] ;
            }
        }
        
        
    }

    /**
     * Finds the Tblshop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tblshop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        
        if (($model = Tblshop::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     public function actionTest($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
}
