<?php

namespace app\controllers;

use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\User;
use app\models\UserSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
       
       $this->getuser();
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {

            //      $t = Yii::$app->runAction('log/set', ['data' => $model,
            //'op' => $model->className() . '-->' . $this->action->id]);

            $model->setAttribute('level', 70);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $usrid = Yii::$app->user->Id;
        $ris = user::find()
            ->select(['level', 'cd_cli', 'id'])
            ->where(['id' => $usrid])
            ->asArray()
            ->one();

        if ($id != Yii::$app->user->Id and $ris['level'] != 100) {
            die('ACCESSSO NON AUTORIZZATO ');

        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // var_dump(implode($model->moduli));
            // die(  print_R( $_POST['User']['file']));
            $chkfile = UploadedFile::getInstance($model, 'file');

            if ($chkfile != null) {
                $model->file = UploadedFile::getInstance($model, 'file');
            } else {
//die('filenull');
                $model->file = $model->getOldAttribute('file');
            }
            if (is_array($model->moduli)) {
                $model->setAttribute("moduli", serialize($model->moduli));
                //implode('|', $model->moduli));
            }
            if (is_array($model->reports)) {
                $model->setAttribute("reports", serialize($model->reports));
                //implode('|', $model->reports));
            }

            //    die(print_r($_POST['User']['password']));

            if (isset($_POST['User']['password'])) {

                if ($_POST['User']['password'] != null || trim($_POST['User']['password']) != '') {
                    $model->setAttribute('password_hash',
                        Yii::$app->security->generatePasswordHash($_POST['User']['password']));
                    //        die(print_r(Yii::$app->security->generatePasswordHash($model->password)));
                }

            }
            $v = Yii::$app->user->Id;
            $ris = user::find()
                ->select(['level', 'cd_cli', 'id'])
                ->where(['id' => $usrid])
                ->asArray()
                ->one();
//die(print_R($model->file));

            $t = Yii::$app->runAction('log/set', ['data' => $model,
                'op' => $model->className() . '-->' . $this->action->id]);

            $mailFailed = false;
            if ($model->getOldAttribute('moduli') != $model->moduli) {

                isset($user) ?: $user = $model;

                try {
                    Yii::$app
                        ->mailer
                        ->compose(
                            ['html' => 'attivato-html',
                                'text' => 'attivato-text'],
                            ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] =>
                            Yii::$app->name . ' robot'])
                        ->setTo($model->email)
                        ->setSubject('Attivazione del portale ' . Yii::$app->name)
                        ->send();
                } catch (\Exception $e) {
                    $mailFailed = true;
                    Yii::error('Invio email fallito (User/update): ' . $e->getMessage(), __METHOD__);
                }

            }

            $model->lastlogin = $model->getOldAttribute('lastlogin');
                $chk_limit=
                //user::find()
                // ->where(["level<>100 and status=10 and cd_cli is not null"])
                //->count(["id"]);
                // ->asArray;
              //  ->one();
           (new \yii\db\Query())
    ->from('user')
    ->where('level<>100 and status=10 and cd_cli is not null and ischief is null')
    ->count();

//die(var_dump($chk_limit));

                if($chk_limit>=55 && $model->getOldAttribute('cd_cli')==null &&
                $model->cd_cli != null
                )
            {

              //  die('superato il limite di utenti attivabili!!!');
               
              Yii::$app->session->setFlash('limitutenti');

              return $this->redirect(['index']);

            }




            if ($model->save()) {
                if ($mailFailed) {
                    Yii::$app->session->setFlash('mail_failed',
                        'L\'utente è stato salvato, ma non è stato possibile inviare l\'email di attivazione.');
                }
            } else {
                echo "MODEL NOT SAVED";
                print_r($model->getAttributes());
                print_r($model->getErrors());
                exit;
            }

            if ($chkfile != null) {
                $model->upload();
            }
            if ($ris['level'] == 100) {
                return $this->redirect(['index']);
            } else {
                return $this->redirect(['index']);
                //$this->redirect(['view', 'id'=> $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        return false;
        $model = $this->findModel($id);
        $t = Yii::$app->runAction('log/set', ['data' => $model,
            'op' => $model->className() . '-->' . $this->action->id]);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
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
//->AsArray();
$messaggio =
    "<h1>Attenzione</h1>\n\n"
    . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";



 $ris ?? $this->denyAccess();


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
        $messaggio =
    "<h1>Attenzione</h1>\n\n"
    . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";

$ris ?? $this->denyAccess();

        $arrmod = unserialize($ris['moduli']);
        $go = 0;
        if ($ris['level'] != 100) {
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
    public function actionRp()
    {
        $mmodel = new PasswordResetRequestForm();
        if ($mmodel->load(Yii::$app->request->post())) {
            //return $model;
            /*
            Yii::$app->mailer->compose()
            ->setFrom('somebody@domain.com')
            ->setTo('myemail@yourserver.com')
            ->setSubject('Email sent from Yii2-Swiftmailer')
            ->send();
             */
            if ($mmodel->sendEmail()) {
                // $mmodel->sendEmail();
                //print_R(Yii::$app->mailer);
                Yii::$app->session->setFlash('inviato');
                //  $t = Yii::$app->runAction('log/set', ['data' => $mmodel,
                //'op' => $model->className() . '-->' . $this->action->id]);

            } else {
                Yii::$app->session->setFlash('errore');
//$t = Yii::$app->runAction('log/set', ['data' => $mmodel,
//    'op' => $mmodel->className() . '-->' . $this->action->id]);
//return print_r($mmodel->sendEmail());

            }
            //   return   $this->refresh();

            return $this->goHome();

            /*
            }else{

            return "ERRORE DI INVIO EMAIL";
            }
             */
            /*&& $model->validate()) {

        if ($model->sendEmail()) {
        Yii::$app->session->setFlash('success',
        'Check your email for further instructions.');
        die();
        return  $model;

        } else {
        Yii::$app->session->setFlash('error',
        'Sorry, we are unable to reset password for email provided.');
        }*/
        } else {
            return $this->render('rp', ['model' => $mmodel]);
        }
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    /*  public function actionResetp($token)
    {
    try {
    //  $model = new ResetPasswordForm($token);
    if ($token !== null) {
    $ris = user::find()
    // ->select(['level', 'cd_cli'])

    ->where(['password_reset_token' => $token])
    ->one();
    $model = $ris;
    }
    //  yii::warning($model);
    } catch (InvalidParamException $e) {
    throw new BadRequestHttpException($e->getMessage());
    }

    if ($model->load(Yii::$app->request->post())
    && $model->validate()
    && $model->resetPassword()) {
    Yii::$app->session->setFlash('success', 'New password was saved.');

    return $this->goHome();
    }

    return $this->render('preset', [
    'model' => $model,
    ]);
    }*/

    public function actionResetp($token)
    {
        $model = new ResetPasswordForm($token);
        if ($model->load(Yii::$app->request->post())
            && $model->validate()
            && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->renderpartial('preset', [
            'model' => $model,
        ]);

    }

    public function actionCf($id)
    {
        $model = User::findOne($id);
        return
        $this->render('update', [
            'model' => $model,
        ]);
    }
}
