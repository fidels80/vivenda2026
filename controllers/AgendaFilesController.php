<?php

namespace app\controllers;

use Yii;
use app\models\AgendaFiles;
use app\models\AgendafilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
 
use yii\web\UploadedFile;
/**
 * AgendafilesController implements the CRUD actions for AgendaFiles model.
 */
class AgendafilesController extends Controller
{
    use AccessDeniedTrait;
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
     * Lists all AgendaFiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->getuser();
        $searchModel = new AgendafilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AgendaFiles model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        //$this->getuser();

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AgendaFiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->getuser();

        $model = new AgendaFiles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionCreateaj()
    {
        $this->getuser();

//        $model = new AgendaFiles();
//
//      if ($model->load(Yii::$app->request->post()) && $model->save()) {
//         return $this->redirect(['view', 'id' => $model->id]);
//    }

//        return $this->renderAjax('create', [
//            'model' => $model,
//        ]);
       
        // $tmmodel = array();
       // print_r( $model->load(Yii::$app->request->post()));
       
//echo 'sadadas';
            //$model->f_content=;
          //  echo $model['uplfile'];
        // $model->f_content= UploadedFile::getInstance($model, 'uplfile');
            
           // $tmf=file_get_contents($ci->getTempName());
           // $model->f_content=$tmf;
            //$ci->saveAs();
            $model = new AgendaFiles();
            if ($model->load(Yii::$app->request->post())){
            print_R(  (Yii::$app->request->post())) ;
            $model->id_agenda=$_post['id_agenda'];
            $model->file=UploadedFile::getInstance($model, 'file');
            $model->nome_file=basename($model->file );
            $model->estenzione=pathinfo($model->file ,PATHINFO_EXTENSION);
           //$model->save();
            $model->upload();
            //$model->save();
            $tmf='0x'.bin2hex(file_get_contents(Yii::getAlias('@webroot').'/uploads/'. 
            str_replace(' ', '_',$model->nome_file) ));
            $model->f_content=$tmf;
            if ($model->save(false)) {
            echo 'save ';
            }
            else {
                echo 'notsave';
            }
           // print_R($tmf);

  //          var_Dump($ci);
    //    if ($model->save(false) ) {
            //  \Yii::$app->response->format = Response::FORMAT_JSON;
            //Yii::warning( ($model));
          /*  return ['id' => $model->id,
            'id_agenda' => $model->id_agenda,
            'descrizione' => $model->descrizione,'nota' =>
             $model->nota,
                'f_content' => $model->f_content,'nome_file' =>
                $model->nome_file,'estenzione' => $model->estenzione];
        */
      //   echo 'salvato';
    //}else{echo 'svaccato';}



    }else//if //(Yii::$app->request->isAjax) 
        {
            return $this->render
            //Ajax
            ('create', ['model' => $model]);
        }

    }
    
    /**
     * Updates an existing AgendaFiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->getuser();

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AgendaFiles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->getuser();

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AgendaFiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AgendaFiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $this->getuser();

        if (($model = AgendaFiles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }














public function getuser(){
$usrid = Yii::$app->user->Id;

if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['level', 'cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
//->AsArray();

}
//var_dump($ris);
if (Yii::$app->user->isGuest || $ris['level'] == null) {

// throw new \yii\web\ForbiddenHttpException("403");
$messaggio=
"<h1>Attenzione</h1>\n\n"
. "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";

$this->denyAccess();

}


}





}
