<?php

namespace app\controllers;

use yii\web\Response;
use Yii;
use app\models\Relusrformaction;
use app\models\RelusrformactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * RelusrformactionController implements the CRUD actions for Relusrformaction model.
 */
class RelusrformactionController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all Relusrformaction models.
     * @return mixed
     */
    public function actionIndex() {
          $result= yii::$app->runAction('relusrformaction/getursper',['cont'=>Yii::$app->controller->id,'act'=>Yii::$app->controller->action->id]);
 //      yii::warning($result);
      // return $result;
       if ($result==0){
       return 'non sei autorizzato!';
       }
        $searchModel = new RelusrformactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Relusrformaction model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
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
     * Creates a new Relusrformaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
          $result= yii::$app->runAction('relusrformaction/getursper',['cont'=>Yii::$app->controller->id,'act'=>Yii::$app->controller->action->id]);
 //      yii::warning($result);
      // return $result;
       if ($result==0){
       return 'non sei autorizzato!';
       }
        $model = new Relusrformaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Relusrformaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
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
     * Deletes an existing Relusrformaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
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
     * Finds the Relusrformaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Relusrformaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Relusrformaction::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getcontroller() {
        $controllerlist = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controllerlist[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        $fulllist = [];
        foreach ($controllerlist as $controller):
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;
        //\Yii::$app->response->format = Response::FORMAT_JSON;
        return $fulllist;
    }

    public function actionList() {
        if (Yii::$app->user->isGuest) {
            return 'non sei autorizzato!';
        } else {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            Yii::warning("azione");
            $out = [];
            if (isset($_POST['depdrop_parents'])) {
                $id = end($_POST['depdrop_parents']);
                Yii::warning($id);
                $controllerlist = [];
                if ($handle = opendir('../controllers')) {
                    while (false !== ($file = readdir($handle))) {
                        if ($file == $id . 'Controller.php') {
                            $controllerlist[] = $file;
                        }
                    }
                    closedir($handle);
                }
                asort($controllerlist);
                $fulllist = [];

                Yii::warning($controllerlist);
                foreach ($controllerlist as $controller):
                    $handle = fopen('../controllers/' . $controller, "r");
                    Yii::warning($handle);
                    $i = 0;
                    if ($handle) {
                        while (($line = fgets($handle)) !== false) {
                            if (preg_match('/public function action(.*?)\(/', $line, $display)):
                                if (strlen($display[1]) > 2):
                                    //  $fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
                                    //    $fulllist[$display[1]]=$display[1];
                                    //      $fulllist['id']=$display[1];
                                    //     $fulllist['name'] =$display[1];
                                    // $fulllist['id'=$display[1],'name'=$display[1]];
                                    $fulllist[] = ['id' => $display[1], 'name' => $display[1]];
                                endif;
                            endif;
                            $i = $i + 1;
                        }
                    } else {
                        Yii::warning('handle false');
                    }
                    fclose($handle);
                endforeach;
                Yii::warning($fulllist);
                //return $fulllist;
                return ['output' => $fulllist, 'selected' => ''];
            }
        }
    }

    public function actionGetursper($cont = null, $act = null) {
        $id = \Yii::$app->user->identity->id;
        $lvl = \Yii::$app->user->identity->level;
        if ($lvl == 100) {
            return 1;
        }
        $find = Relusrformaction::find()
                //  ->where (['id_user'=>$id])
                //  ->andwhere(['form'=>$cont])
                //  ->andwhere(['azione'=>$act])
                //  ->orWhere(['<=','level',$lvl]) 
                ->where('(id_user=:id and form=:form and azione=:act)', [':id' => $id, ':form' => $cont, ':act' => $act])
                ->orwhere('(level<=:lvl and form=:form and azione=:act)', [':lvl' => $lvl, ':form' => $cont, ':act' => $act])
                ->all();
        //->asArray();
        //return $find->sql; 
        // return $find;
        /*
         * $query->where([
          'status' => 10,
          'type' => null,
          'id' => [4, 8, 15],
          ]);
         * 
         */
        if (isset($find) == false || empty($find)) {
            return 0;
        } else {
            return 1;
        }
    }

}
