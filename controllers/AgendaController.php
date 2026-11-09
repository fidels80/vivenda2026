<?php

namespace app\controllers;

use app\models\form\FilesForm;
use app\models\Agenda;
use app\models\AgendaFiles;
use app\models\AgendaSearch;
use app\models\Locazioni;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\user;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

//use app\models\form\FileForm;

/**
 * AgendaController implements the CRUD actions for Agenda model.
 */
class AgendaController extends Controller
{
    use AccessDeniedTrait;
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Agenda models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->getuser();

        $searchModel = new AgendaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Agenda model.
     * @param int $id ID
     * @return string
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
     * Creates a new Agenda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function old_actionCreate()
    {
        $this->getuser();

       $model=new Agenda();
         if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }  
        
        return $this->render('create', [
            'model' => $model,
        ]);
 
    }

    /**
     * Updates an existing Agenda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function old_actionUpdate($id)
    {
        $this->getuser();

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())
         && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Agenda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->getuser();

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Agenda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Agenda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function old_findModel($id)
    {
        $this->getuser();

        if (($model = Agenda::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function actionCreate()
    {
        $this->getuser();

        $model = new FilesForm();
        $model->Agenda = new Agenda;
        $model->Agenda->loadDefaultValues();
        $model->setAttributes(Yii::$app->request->post());
        
        if (Yii::$app->request->post() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Product has been created.');
            return $this->redirect(['update', 'id' => $model->Agenda->id]);
        }
        return $this->render('create', ['model' => $model]);
    }
    
    public function actionUpdate($id)
    {
        $this->getuser();

        $model = new FilesForm();
        $model->Agenda = $this->findModel($id);
        $model->setAttributes(Yii::$app->request->post());
        //$this->genfile($id);
        
        if (Yii::$app->request->post() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Product has been updated.');
            return $this->redirect(['update', 'id' => $model->Agenda->id]);
        }
        
        return $this->render('update', ['model' => $model]);
    }
    
    protected function findModel($id)
    {
        $this->getuser();

        if (($model = Agenda::findOne($id)) !== null) {
            return $model;
        }
        throw new HttpException(404, 'The requested page does not exist.');
    }

    public  function  actionGenfile($id,$filename=null){
        $this->getuser();

        $tmpfile= AgendaFiles::find()->where(['id'=>$id])->asArray()->one() ;
 //var_dump($tmpfile);
                try {
                $path=Yii::getAlias('@webroot').'/uploads/';
                $file=str_replace(' ', '_',$tmpfile['nome_file']);
                 $file2 = $path . $tmpfile['id'].'_'.$file;
                 //yii::warning
        //         var_dump($tmpfile['nome_file']);
                
                    if (!is_null($tmpfile['nome_file'])) {
                        $tmf=fopen($file2,'w');
                             fwrite($tmf,$tmpfile['f_content']) ;
                            fclose($tmf);
                   $tmpf=
                 Yii::$app->response->SendFile(
                     $file2,
                     $file,
                     $options = ['inline'=>false]
                    // file_get_contents($file2, FILE_USE_INCLUDE_PATH)
                    // 'application/pdf'
                 ); 
                }
                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
                 ob_clean();
                 unlink($file2);
         // return $tmpf;//    file_get_contents( $file2 );
//return 'stocazzo';


    }




















    public function actionJsoncalendar($start = null, $end = null, $_ = null, $filtro = null)
    {
$this->getuser();

        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (isset($filtro)) {
            //echo \gettype($filtro);
            //var_Dump(explode(',', $filtro));

        }

        $times = Agenda::find()->all();

        $events = array();
        //   $BackgroundEvent=array();
        foreach ($times as $time) {
            //Testing
            //   $Event = new \yii2fullcalendar\models\Event();

            $id = $time->id;
            $title = $time->elemento;
            $start = (($time->dadata));
            $end = (($time->adata));
            $overlap = true;
            $startEditable = true;

            //  $Event->durationEditable = true;
            $allDay = false;
            //  $Event->display= 'list-item';
            $el = trim($time->elemento);
            $tmpcol = Locazioni::find()->where(['id' => $el])->one();
            if (isset($filtro)) {
                yii::warning('filtrato');
                if (in_array($title, explode(',', $filtro)) == true) {
                    $Event = array('id' => $id,
                        'title' => $title,
                        'start' => $start,
                        'end' => $end,
                        'overlap' => $overlap,
                        'startEditable' => $startEditable,
                        'allDay' => $allDay,
                        'color' => $tmpcol->colore,
                        'url' => Url::to(['/agenda/view', 'id' => $id]),
//'BackgroundEvent'=>array('color'=>$Color)
                    );
                }
            } else {
                $Event = array('id' => $id,
                    'title' => $title,
                    'start' => $start,
                    'end' => $end,
                    'overlap' => $overlap,
                    'startEditable' => $startEditable,
                    'allDay' => $allDay,
                    'color' => $tmpcol->colore,
                    'url' => Url::to(['/agenda/view', 'id' => $id]),
//'BackgroundEvent'=>array('color'=>$Color)
                );
            }

            $events[] = $Event;
        }
        Yii::warning($events);
        return json_encode(array_values(array_filter(array_unique($events, SORT_REGULAR))));
    }

    public function actionSelcal($filtro = null)
  
    {$this->getuser();

        $fil = '';
        $filtro2 = explode(',', $filtro);
        return $this->render('selcal', [
            'filtro' => $filtro2,
        ]);

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
