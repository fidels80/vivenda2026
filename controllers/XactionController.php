<?php

namespace app\controllers;

use Yii;
use app\models\Xaction;
use app\models\XactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * XactionController implements the CRUD actions for Xaction model.
 */
class XactionController extends Controller
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
     * Lists all Xaction models.
     * @return mixed
     */
    public function actionIndex()
    {
          $result= yii::$app->runAction('relusrformaction/getursper',['cont'=>Yii::$app->controller->id,'act'=>Yii::$app->controller->action->id]);
 //      yii::warning($result);
      // return $result;
       if ($result==0){
       return 'non sei autorizzato!';
       }
        $searchModel = new XactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Xaction model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
          $result= yii::$app->runAction('relusrformaction/getursper',['cont'=>Yii::$app->controller->id,'act'=>Yii::$app->controller->action->id]);
 //      yii::warning($result);
      // return $result;
       if ($result==0){
       return 'non sei autorizzato!';
       }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Xaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
          $result= yii::$app->runAction('relusrformaction/getursper',['cont'=>Yii::$app->controller->id,'act'=>Yii::$app->controller->action->id]);
 //      yii::warning($result);
      // return $result;
       if ($result==0){
       return 'non sei autorizzato!';
       }
        $model = new Xaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Xaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
          $result= yii::$app->runAction('relusrformaction/getursper',['cont'=>Yii::$app->controller->id,'act'=>Yii::$app->controller->action->id]);
 //      yii::warning($result);
      // return $result;
       if ($result==0){
       return 'non sei autorizzato!';
       }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Xaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
          $result= yii::$app->runAction('relusrformaction/getursper',['cont'=>Yii::$app->controller->id,'act'=>Yii::$app->controller->action->id]);
 //      yii::warning($result);
      // return $result;
       if ($result==0){
       return 'non sei autorizzato!';
       }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Xaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Xaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
          $result= yii::$app->runAction('relusrformaction/getursper',['cont'=>Yii::$app->controller->id,'act'=>Yii::$app->controller->action->id]);
 //      yii::warning($result);
      // return $result;
       if ($result==0){
       return 'non sei autorizzato!';
       }
        if (($model = Xaction::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
