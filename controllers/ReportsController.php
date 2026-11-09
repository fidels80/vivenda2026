<?php
namespace app\controllers;

 


use yii\helpers\Url;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\UploadImageForm;
use app\models\User;
use app\models\Xmenu;
use app\models\Xsubmenu;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;
use kartik\grid\GridView;
//use app\models\form\FileForm;

/**
 * AgendaController implements the CRUD actions for Agenda model.
 */
class ReportsController extends Controller
{
    use AccessDeniedTrait;





public function actionIndex()
    {
        $this->getuser();

     //   $searchModel = new FilesSearch();
      //  $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index');//, [
           // 'searchModel' => $searchModel,
           // 'dataProvider' => $dataProvider,
        //]);
    }









public function actionZreport()
    {
        $report = new \app\views\reports\myreport;
        $report->run();
        return $this->render('report',array(
            "report"=>$report
        ));
        
    }


public function actionChart()
    {
 
        return $this->render('chart');
        
    }




      public function getuser(){
$usrid = Yii::$app->user->Id;

if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['level', 'cd_cli','moduli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
//->AsArray();
$nmod = (str_replace('app\controllers', '', str_replace('Controller', '', __CLASS__)));
$nmod = (str_replace('\\', '', $nmod));
//yii::error('---------nmod----');

$nmod=strtoupper($nmod);
yii::error($nmod);

$mn=(new \yii\db\Query())
        ->select(['voce', 'url','Nmodulo'])
        ->from('xmenu')
        ->where(['upper(Nmodulo)' => strtoupper($nmod)])
        ->one();
}

 $arrmod=unserialize($ris['moduli']);
$go=0;
if ($ris['level'] <>100) {
    foreach ($arrmod as  $value) {
        if (strtoupper($value)==strtoupper($mn['voce'])) {
         $go=1;
           }
    }
}else{
    $go=1;
}
//var_dump($ris);
if (Yii::$app->user->isGuest || $ris['level'] == null) {

$messaggio =
    "<h1>Attenzione</h1>\n\n"
    . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";

$this->denyAccess();

}

if($go==0){

$messaggio =
    "<h1>Attenzione</h1>\n\n"
    . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";

$this->denyAccess();



}


}
}
?>