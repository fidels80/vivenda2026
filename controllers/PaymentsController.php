<?php

namespace app\controllers;

use Yii;
use app\models\Payments;
use app\models\PaymentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * PaymentsController implements the CRUD actions for Payments model.
 */
class PaymentsController extends Controller
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
     * Lists all Payments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->getuser();


$usrid = Yii::$app->user->Id;

if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['level', 'cd_cli', 'moduli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();

    $query2 = yii::$app->db2
    ->createCommand(
        '
          delete  from 
 web_frontier.dbo.payments  where cd_cli=:cli and xid_Sc in (
select id_Sc from ADB_VIVENDASRL.dbo.sc
 where timeupd >= DATEADD(DAY, -100, GETDATE()))
          
          
          insert into  web_frontier.dbo.payments 
          (xid_testa,cd_cli,Cd_PG,DataScadenza,DataPagamento,DataFattura,NumFattura,
          Protocollo,Pagata,TotEffetti,ImportoV,IncassoV,xid_sc,NumEffetto)
    
    select Id_DOTes,Cd_CF,cd_pg,DataScadenza,DataPagamento,DataFattura,NumFattura,Protocollo,
    Pagata,TotEffetti,ImportoV,IncassoV,Id_SC,NumEffetto
         from ADB_VIVENDASRL.dbo.SC
     where Cd_CF like \'C%\'  and cd_cf=:cf
     and Id_SC not in (select xid_Sc from web_frontier.dbo.payments)





    '
    )->bindValues([':cli'=>$ris['cd_cli'],':cf'=>$ris['cd_cli']]);

    $query2->execute();
}
        $searchModel = new PaymentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payments model.
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
     * Creates a new Payments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->getuser();

        $model = new Payments();

        if ($model->load(Yii::$app->request->post())  ) {

            $t = Yii::$app->runAction('log/set', ['data' => $model,
    'op' => $model->className() . '-->' . $this->action->id]);
$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Payments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->getuser();

        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post())   ) {
            $t = Yii::$app->runAction('log/set', ['data' => $model,
    'op' => $model->className() . '-->' . $this->action->id]);
$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Payments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->getuser();
$t = Yii::$app->runAction('log/set', ['data' => $model,
    'op' => $model->className() . '-->' . $this->action->id]);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Payments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $this->getuser();
        if (($model = Payments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

           public function getuser(){
$usrid = Yii::$app->user->Id;

if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['level', 'cd_cli', 'moduli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
//->AsArray();
    $nmod = (str_replace('app\controllers', '', str_replace('Controller', '', __CLASS__)));
    $nmod = (str_replace('\\', '', $nmod));
//yii::error('---------{'.$nmod.'}----');

    $nmod = strtoupper($nmod);
//yii::error($nmod);

    $mn = (new \yii\db\Query())
        ->select(['voce', 'url', 'Nmodulo'])
        ->from('xmenu')
        ->where(['upper(Nmodulo)' => strtoupper($nmod)])
        ->one();
}

$arrmod = unserialize($ris['moduli']??'');
$go = 0;
if (($ris['level'] ?? 0)!= 100) {
    if (is_array($arrmod)) {
        foreach ($arrmod as $value) {
            //   yii::error('---------{'.strtoupper($value).'}----{'.strtoupper($mn['voce']).'}----{');
            if (strtoupper($value) == strtoupper($mn['voce'])) {
                $go = 1;
            }
        }
    }

} else {
    $go = 1;
}
//var_dump($ris);
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
}
