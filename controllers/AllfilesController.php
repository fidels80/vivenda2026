<?php

namespace app\controllers;

use app\models\Allfiles;
use app\models\AllfilesSearch;
use app\models\doc_head;
use app\models\Elemail;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * AllfilesController implements the CRUD actions for Allfiles model.
 */
class AllfilesController extends Controller
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
     * Lists all Allfiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->getuser();

        $searchModel = new AllfilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Allfiles model.
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
     * Creates a new Allfiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->getuser();

        $model = new Allfiles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    // ajupd

    public function actionAjupd()
    {
        $this->getuser();
        //
$tmodel = new   \yii\base\DynamicModel(['nota','files','origine','id_padre']);
$tmodel->addRule('nota', 'string');
$tmodel->addRule('origine', 'string');
$tmodel->addRule('id_padre', 'integer');

$tmodel->addRule('files','file', ['maxFiles' => 10]);



        //  mb_internal_encoding( 'UTF-8' );
        if ($tmodel->load(Yii::$app->request->post())) {
           // $x = $model->f_content;
            //   $tmpfile=UploadedFile::getInstance($model, 'f_content');
            $tmodel->files = UploadedFile::getInstances($tmodel, 'files');
$a='';
$atc2 = $tmodel->files;
//return print_r($model->files);

foreach ($atc2 as $file) {
    // $file->saveAs(
    // $t=$t.
    $model = new Allfiles();
$tmpfile=$file;
    $a=$a. (($file->baseName . '.' . $file->extension));


    //return  print_r($a);
$h = //'0x'.bin2hex((binary)
//pack("0x*",

(binary) (file_get_contents($tmpfile->tempName));
 
            $model->nomefile = basename($tmpfile);
    $model->origine = 'S';
    $model->estensione = pathinfo($tmpfile, PATHINFO_EXTENSION);
    $model->setAttribute('f_content', '');
    //$model->setAttribute('nota', $tmodel->nota);
$model->setAttribute('id_padre', $tmodel->id_padre);
$model->setAttribute('entita', 'DOTES');

         /* [['id_padre'], 'integer'],
            [['f_content'], 'string'],
            [['entita'], 'string', 'max' => 128],
            [['nomefile'], 'string', 'max' => 260],
            [['estensione'], 'string', 'max' => 3],
            [['origine'], 'string', 'max' => 1],
            [['nota'], 'string'],
    //riattivare*/

      $model->save(false);

    $id = $model->getPrimaryKey();
    $connection = Yii::$app->getDb();
    $command = $connection->createCommand("
           update all_files set f_content=convert(
            VARBINARY(max) ,
            :contenuto ,1) where id=:id
           ", [':id' => $id, ':contenuto' => '0x' . bin2hex($h)]);
    $command->execute();
    //\Yii::$app->response->format = Response::FORMAT_JSON;
    $query2 = yii::$app->db2
        ->createCommand(
            "
     alter table DmsDocument alter column LinkedToFS bit    null

    insert into DmsDocument(
    content,
    entityTable,
    descrizione,
    filename,
    EntityId,
DocumentDate,
--LinkedToFS,
filesize,
FilePath,
note,
ComputerName,
id_dmsclass1,
id_dmsclass2,
dmsclass3,
EntityDescription,
Cd_DmsType,xid
)

 select
  f_content as content,
entita as entityTable,
'caricato da portale web ' + nomefile as descrizione,
nomefile as [filename],
id_padre as entityid,
--0 as LinkedToFS,
getdate() as documentdate,
:filesize as filesize,
'\\web\upload\' as FilePath,
'caricato da portale web ' + nomefile as note,
'Portal' as ComputerName,
1 as id_dmsclass1 ,
5 as id_dmsclass2 ,
cd_doc as id_dmsclass3,
cd_doc+ numdoc +' del ' +convert(varchar(10),data) as EntityDescription,
'00' as Cd_DmsType,:xid
from web_frontier.dbo.all_files
left join  web_frontier.dbo.doc_head on doc_head.xid_testa=id_padre
 where id_padre=:idpadre   and all_files.id=:allfilesid



 update dmsdocument set LinkedToFS=0  where LinkedToFS=null
 alter table DmsDocument alter column LinkedToFS bit  not  null

"
        )

        ->bindValues([':allfilesid' => $model->id,
            ':idpadre' => $model->id_padre,
            ':xid' => $model->id,

            ':filesize' => $tmpfile->size]);

    //riattivare
    $query2->execute();
}
            $usrid = Yii::$app->user->Id;

            if ($usrid !== null) {
                $ris = (new \yii\db\Query())
                    ->select(['email', 'cd_cli'])
                    ->from('user')
                    ->where(['id' => $usrid])
                    ->one();
                //->AsArray();
            }

            $ldoc = doc_head::find()->where(['xid_testa' => $model->id_padre])->one();
            $xn = (isset($model->nota) ? 'Nota:' . PHP_EOL . $model->nota : '');
            $subject = "Caricamento dei file per il cliente " . $ldoc['cd_cli'];
            $body = "Sono stati caricati dei file " . PHP_EOL . 
            " Sono relativi al documento "
             . $ldoc['cd_doc'] . ' numero ' 
             . $ldoc['numdoc'] . ' del ' . $ldoc['data'] . PHP_EOL .
                $xn
                . PHP_EOL .
                'Saluti ';

            $message = Yii::$app->mailer->compose()
//->setTo(Yii::$app->params['senderEmail'])
                ->setto($ris['email'])
                ->setFrom(yii::$app->params['supportEmail'])
                ->setReplyTo([yii::$app->params['supportEmail']])
                ->setSubject($subject)
                ->setTextBody($body);

            $message2 = Yii::$app->mailer->compose()
                ->setTo(yii::$app->params['adminEmail'])
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo($ris['email'])
                ->setSubject($subject)
                ->setTextBody($body);
//  ->attach($this->files);

            $mailFailed = false;
            try {
                $message->send();
                $message2->send();
            } catch (\Exception $e) {
                $mailFailed = true;
                Yii::error('Invio email fallito (Allfiles/ajupd): ' . $e->getMessage(), __METHOD__);
            }

            if ($mailFailed) {
                Yii::$app->session->setFlash('mail_failed',
                    'Il file è stato salvato, ma non è stato possibile inviare l\'email di notifica.');
            } else {
                $elemail = new Elemail();
                $elemail->setAttribute('nome', $ris['email']);
                $elemail->setAttribute('email', $ris['email']);
                $elemail->setAttribute('Soggetto', $subject);
                $elemail->setAttribute('Corpo', $body);
                $elemail->setAttribute('allegati', $ldoc['id']);

                $elemail->save(false);
            }

/*

$client = new Client();
$response = $client->createRequest()
//->setMethod('POST')
->setUrl('http://vivenda.locl:8080/web/index.php?r=rest/arcapostfile')
->setData([
'content' =>//'pino',
// '0x'.bin2hex($h),
//$model['f_content'],
$tmpfile,
'id' =>
$model['id_padre'],
'fn'=>//'asd',
$model['nomefile'],
'hash'=>'$2y$13$6dpv6XRT1tRQu9RZFfnKvOYIoiOiS5.PHzP5qsQqp1s83LBu90d.6']
)
->send();
if ($response->isOk) {
die (var_dump($response));
//    $newUserId = $response->data['id'];
}else{
die(var_dump($response->content));
}
 */

            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }

        return $this->renderAjax('create', [
            'model' => $tmodel,
        ]);
    }
    /**
     * Updates an existing Allfiles model.
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
     * Deletes an existing Allfiles model.
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
     * Finds the Allfiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Allfiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $this->getuser();

        if (($model = Allfiles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionGenfile($id, $filename =null)
    {

        $this->getuser();



        $usrid = Yii::$app->user->Id;

if ($usrid !== null) {
    $usr_ris = (new \yii\db\Query())
        ->select(['email', 'gruppo','cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
    //->AsArray();
}


        $tmpfile = AllFiles::find()->where(['id' => $id])->asArray()->one();
        //var_dump($tmpfile);
        //die(var_dump($filename));
        try {
            $path = Yii::getAlias('@webroot') . '/uploads/';
          $file = str_replace(' ', '_', $tmpfile['nomefile']);

       if($tmpfile['entita']=='DORIG'){
            if ($usr_ris['cd_cli']<>'C001443'){ 
            $file = str_replace(' ', '_', $tmpfile['nomefile']);
           }else
           {
        $file =  (strstr($tmpfile['nomefile'],'_',true)).'.'.$tmpfile['estensione'];
        $file = $tmpfile['id'].'_'.str_replace(' ', '_', $file);


           }
        }
            $file2 = $path . $tmpfile['id'] . '_' . $file;
            //yii::warning
            //         var_dump($tmpfile['nome_file']);

            if (!is_null($tmpfile['nomefile'])) {

                $tmf = fopen($file2, 'w');
                fwrite($tmf, (
                    $tmpfile['f_content']));
                fclose($tmf);

                $tmpf =
                Yii::$app->response->SendFile(
                    $file2,
                    $file,
                    $options = ['inline' => false]
                    // file_get_contents($file2, FILE_USE_INCLUDE_PATH)
                    // 'application/pdf'
                );
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
        ob_clean();
        unlink($file2);
        // return $tmpf;//    file_get_contents( $file2 );
        //return 'stocazzo';

    }

    public function getuser()
    {
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
