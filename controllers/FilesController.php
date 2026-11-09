<?php

namespace app\controllers;

use Yii;
use app\models\Files;
use app\models\FilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;
/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller
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
     * Lists all Files models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->getuser();

        $searchModel = new FilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Files model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->getuser();

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->getuser();

        $model = new Files();

        if ($model->load(Yii::$app->request->post())   ) {
            Yii::warning($model->file);
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->save();
      if ($model->upload()) {
         // file is uploaded successfully
        // echo "File successfully uploaded";
      //  $searchModel = new FilesSearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         return $this->redirect('index');
      }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Files model.
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
     * Deletes an existing Files model.
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
     * Finds the Files model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Files the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $this->getuser();

        if (($model = Files::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function downloadFile($fullpath){
        $this->getuser();

        if(!empty($fullpath)){
            header("Content-type:application/pdf"); //for pdf file
            //header('Content-Type:text/plain; charset=ISO-8859-15');
            //if you want to read text file using text/plain header
            header('Content-Disposition: attachment; filename="'.basename($fullpath).'"');
            header('Content-Length: ' . filesize($fullpath));
          echo $fullpath;
            //  readfile($fullpath);
           // Yii::$app->end();
        }
    }

    public function actionDownload($id,$file)
    {
        $this->getuser();
      //  $model = Files::findOne($id);
     //   $path =  "http://fidels.synology.me/i3q/web/uploads/";//.Yii::getAlias('@web'."/uploads/") ;
      $path=Yii::getAlias('@webroot').'/uploads/';
       $file=str_replace(' ', '_',$file);
        $file2 = $path . $id.'_'.$file;
        $tmpf= 
        Yii::$app->response->SendFile(
            $file2,$file,$options = ['inline'=>false]
           // file_get_contents($file2, FILE_USE_INCLUDE_PATH)
           // 'application/pdf'
         );
         ob_clean();
return $tmpf;
       
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

$messaggio =
    "<h1>Attenzione</h1>\n\n"
    . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";

$this->denyAccess();

}


}
}
