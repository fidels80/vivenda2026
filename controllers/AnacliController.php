<?php

namespace app\controllers;

use Yii;
use app\models\Anacli;
use app\models\AnacliSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\Model;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
 
/**
 * AnacliController implements the CRUD actions for Anacli model.
 */
class AnacliController extends Controller
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
     * Lists all Anacli models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $this->getuser();

        $searchModel = new AnacliSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Anacli model.
     * @param string $id
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
     * Creates a new Anacli model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
     $this->getuser();

        $model = new Anacli();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cd_cli]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Anacli model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cd_cli]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Anacli model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Anacli model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Anacli the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anacli::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }










public function getuser()
    {
        $usrid = Yii::$app->user->Id;
        if ($usrid !== null) {
            $ris = (new \yii\db\Query())
                ->select(['level', 'cd_cli', 'moduli'])
                ->from('user')
                ->where(['id' => $usrid])
                ->one();
            $nmod = (str_replace('app\controllers', '', str_replace('Controller', '', __CLASS__)));
            $nmod = (str_replace('\\', '', $nmod));
            $nmod = strtoupper($nmod);
            $mn = (new \yii\db\Query())
                ->select(['voce', 'url', 'Nmodulo'])
                ->from('xsubmenu')
                ->where(['upper(Nmodulo)' => strtoupper($nmod)])
                ->one();
                yii::warning($nmod);
        }
        yii::warning($mn['voce'] ?? 'default value');
        $arrmod = unserialize($ris['moduli'] ?? '');
        $go = 0;
        if (($ris['level'] ?? 0) != 100) {
            if (is_array($arrmod)) {
                foreach ($arrmod as $value) {
                    if (strtoupper($value) == strtoupper(($mn['voce'] ?? 'default value'))) {
                        $go = 1;
                    }
                    if ($nmod == 'ANACLI' || strtoupper($value) == 'ELENCO') {
                        $go = 1;
                    }
                }
            }
        } else {
            $go = 1;
        }
        if (($mn['voce'] ?? 'default value')=='default value'){
            $go=0;
        }

        if (Yii::$app->user->isGuest || $ris['level'] == null) {
            $messaggio =
                "<h1>Attenzione</h1>\n\n"
                . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";
            $this->denyAccess();
        }
        if ($go == 0) {
            $messaggio =
                "<h1>Attenzione</h1>\n\n"
                . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";
            $this->denyAccess();
        }
    }





        public function actionList($id=null)
    {
\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


  
 
       
$out = [];
if (isset($_POST['depdrop_parents'])) {
    $id = end($_POST['depdrop_parents']);
    //  $list = Contact::find()->andWhere(['id_ana_ref' => $id])->asArray()->all();
    Yii::info("sono dentro e l'id è" . $id);
    $query = new \yii\db\Query();
    $query->select('altcli as id, desk as name')
        ->from('relcli')
        ->leftjoin('ana_cli','ana_cli.cd_cli=relcli.altcli')
    // ->leftjoin('articoli'  , 'tabtaglie.id = articoli.taglia')
        ->where(['relcli.cd_cli' => $id]);
    //        ->queryAll();
    $rows = $query->all();
    $command = $query->createCommand();
    $data = $command->queryAll();
    foreach ($data as $i => $t) {

        Yii::info("sono dentro e l'il risultato  è    " . $t['name']);
        Yii::info("sono dentro e l'id  è    " . $t['id']);
        //          var_dump($data);
        $out[] = ['id' => $t['id'], 'name' => $t['name']];
        $selected = $t['id'];
    }

    return ['output' => $out, 'selected' => $selected];
} else { $query = new \yii\db\Query();
$query->select('altcli as id, desk as name')
    ->from('relcli')
    ->leftjoin('ana_cli', 'ana_cli.cd_cli=relcli.altcli');
// ->leftjoin('articoli'  , 'tabtaglie.id = articoli.taglia')
//    ->where(['relcli.cd_cli' => $id]);
//

    $rows = $query->all();
    $command = $query->createCommand();
    $data = $command->queryAll();
    $out[] = array_values($data);
    return $out;

}


}
}
