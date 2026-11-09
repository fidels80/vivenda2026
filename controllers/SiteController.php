<?php

namespace app\controllers;

use app\models\CommessaCover;
use app\models\ContactForm;
use app\models\Elemail;
use app\models\LoginForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\UploadImageForm;
use app\models\User;
use app\models\Xmenu;
use app\models\Xsubmenu;
use kartik\grid\GridView;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->render('index', [
                'sottocommesse' => [],
                'coverMap' => [],
            ]);
        }

        // La nuova home con le card delle commesse è visibile agli utenti
        // abilitati tramite il flag in anagrafica oppure tramite la voce di
        // menu "Maxi Affissioni" presente nei moduli dell'utente.
        $identity = Yii::$app->user->identity;
        $hasFlag = $identity->hasAttribute('utente_maxiaffissioni') && !empty($identity->utente_maxiaffissioni);
        $hasMenu = false;
        if (!empty($identity->moduli)) {
            $moduli = @unserialize($identity->moduli);
            if (is_array($moduli)) {
                $hasMenu = in_array('Maxi Affissioni', $moduli, true);
            }
        }
        if (!$hasFlag && !$hasMenu) {
            return $this->render('index_old');
        }

        $env = require Yii::getAlias('@app/config/env.php');
        $stati = $env['stati_commesse'] ?? [];

        $query = (new \yii\db\Query())
            ->select([
                's.Cd_DOSottoCommessa',
                's.Descrizione',
                's.Cd_CF',
                'c.Descrizione AS DescrizioneCF',
                's.Cd_DOCommessaStato',
                'st.Descrizione AS DescrizioneStato',
                's.DataInizio',
                's.DataFinePresunta',
                's.DataFineReale',
            ])
            ->from('DOSottoCommessa s')
            ->leftJoin('cf c', 'c.Cd_CF = s.Cd_CF')
            ->leftJoin('DOCommessaStato st', 'st.Cd_DOCommessaStato = s.Cd_DOCommessaStato');
        if (!empty($stati)) {
            $query->andWhere(['in', 's.Cd_DOCommessaStato', $stati]);
        }
        $query->orderBy(['s.DataInizio' => SORT_ASC]);
        $sottocommesse = $query->all(Yii::$app->db2);

        $covers = CommessaCover::find()->select(['cd_dosottocommessa', 'image_path'])->asArray()->all();
        $coverMap = [];
        foreach ($covers as $c) {
            $coverMap[$c['cd_dosottocommessa']] = $c['image_path'];
        }

        return $this->render('index', [
            'sottocommesse' => $sottocommesse,
            'coverMap' => $coverMap,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        //echo 'asdasdada';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //      yii::warning(Yii::$app->request->post());

            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionResetadmin()
    {
        $model = User::find()->where(['username' => 'admin'])->one();
        //var_dump($model);
        // if (empty($model)) {
        //  $user = new User();
        // $user->username = 'admin';
        $model->email = 'temp.mail@ilvbc.it';
        $model->setPassword('lineaverde');
        //$user->generateAuthKey();
        if ($model->save(false)) {
            die('good');
        } else {
            die('fail');

        }
        //}
    }

    public function actionSignup()
    {

        $user = new User();

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {

            // return (var_dump($model));
            if ($user = $model->signup()) {

                //         $t = Yii::$app->runAction('log/set', ['data' => $model,
                //           'op' => $model->className() . '-->' . $this->action->id]);

                if ($user->save()) {
                    //   echo 'good';
                }

                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {

/*
$model = new PasswordResetRequestForm();
if ($model->load(Yii::$app->request->post()) && $model->validate()) {

if ($model->sendEmail()) {
Yii::$app->session->setFlash('success',
'Check your email for further instructions.');

return $this->goHome();

} else {
Yii::$app->session->setFlash('error',
'Sorry, we are unable to reset password for email provided.');
}
}

//        return $this->render('requestPasswordResetToken', [
//          'model' => $model,
//    ]);
return $this->goHome();

var_dump ('giampaolo.schiappoli@programma2000.com');

//      return $model;*/
//return $this->goHome();
        return $this->renderajax('site/requestPasswordResetToken');
//, [
        //          'model' => $model,
        //    ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()
            && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('RequestPasswordReset', [
            'model' => $model,
        ]);
    }

    public function actionUploadImage()
    {
        $model = new UploadImageForm();
        if (Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->upload()) {
                // file is uploaded successfully
                echo "File successfully uploaded";
                return;
            }
        }
        return $this->render('upload', ['model' => $model]);
    }

    public function actionBleft()
    {
        // ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],

        $items = [];

        $model = User::find()->where(['username' => \Yii::$app->user->identity->username])->
            AsArray()->one();

        $moduli = unserialize($model['moduli']);
        $moduli2 = unserialize($model['moduli']);

        //   yii::error($moduli);
        if ($model['level'] == 100) {
            $adm_voicem = [];
            $adm_menu = xmenu::find()->AsArray()->all();
            foreach ($adm_menu as $value) {
                $adm_voicem[] = ($value['voce']);

            }

            $moduli = $adm_voicem;
            //     yii::error($adm_voicem);
        }

        if ($moduli == false) {
            $moduli = 'HOME';
        }

        $menu = xmenu::find()->where(
//'<=','level',$model['level']
            'level<=:level ', //and id<>7
            [':level' => $model['level']]
        )
            ->andwhere(
                'level<>:id',
                [':id' => 100]
            )
            ->andwhere(['voce' => $moduli])
            ->AsArray()->all();

        // Se l'utente ha il permesso su una voce di sottomenu ma non sul
        // relativo menu padre, mostra comunque il padre (con i soli figli
        // abilitati). Evita che voci come Documenti -> Elenco spariscano
        // quando in anagrafica è presente solo la voce figlia.
        $parentIds = (new \yii\db\Query())
            ->select('id_menu')
            ->distinct()
            ->from('xsubmenu')
            ->where(['voce' => $moduli2])
            ->andWhere('level<=:level', [':level' => $model['level']])
            ->column();

        if (!empty($parentIds)) {
            $extraMenu = xmenu::find()
                ->where(['id' => $parentIds])
                ->andWhere('level<=:level', [':level' => $model['level']])
                ->andWhere('level<>:id', [':id' => 100])
                ->AsArray()->all();

            $menuById = [];
            foreach (array_merge($menu, $extraMenu) as $menuItem) {
                $menuById[$menuItem['id']] = $menuItem;
            }
            $menu = array_values($menuById);
        }
        //  yii::error($menu);

        foreach ($menu as $value) {
            # code...
            $xsm = Xsubmenu::find()->where(
                //'<=','level',$model['level']
                'level<=:level',
                [':level' => $model['level']]
            )
                ->andwhere(
                    'id_menu=:id',
                    [':id' => $value['id']]
                )
                ->andwhere(['voce' => $moduli2])
                ->AsArray()->all();
            $sb = [];

            if (count($xsm) > 0) {
                foreach ($xsm as $Svalue) {
                    # code...
                    $items3 = array(
                        'label' => $Svalue['voce'],
                        'url' => Url::toRoute($Svalue['url']),
                        //          'target' => 'self_',
                        'icon' => $Svalue['icona'],
                    );

                    $sb[] = $items3;
                }
            }

            $items2 = array(
                'label' => $value['voce'],
                'url' => Url::toRoute($value['url']),
                //    'target' => 'self_',
                'icon' => $value['icona'],
                'items' => $sb,

            );

            $items[] = $items2;
        }

        $items[] = array(
            'label' => 'Utente', //. Yii::$app->user->id,
            'url' => Url::toRoute(['/user/update', 'id' => Yii::$app->user->id]),
            //    'target' => 'self_',
            'icon' => 'user', //$value['icona'],
            'items' => $sb,

        );

        $items[] = array(
            'label' => 'Ultimo Accesso',
            'icon' => 'calendar',
        );

        $ris = (new \yii\db\Query())
            ->select(['cd_cli', 'email', 'username', 'piva', 'lastlogin'])
            ->from('user')
            ->where(['id' => Yii::$app->user->getId()])
            ->one();

        $items[] = array(
            'label' => date_format(date_create($ris['lastlogin']), "d/m/Y H:i"),
            'icon' => 'sign-out',
        );

        if ($model['level'] >= 100) {
            $items2[] = array(
                'label' => 'ADMIN UTENTI', //. Yii::$app->user->id,
                'url' => Url::toRoute(['/user']),
                //    'target' => 'self_',
                'icon' => 'user', //$value['icona'],
                //  'items' => $sb,

            );

            $sbz = [];

/*$itemsz3 = array(
'label' =>  'voce' ,
'url' =>'',
//          'target' => 'self_',
'icon' => $Svalue['icona'],
);
 */
            $admn = xsubmenu::find()->where('level>=:level ', //and id<>7
                [':level' => 100]
            )->AsArray()->all();
//var_dump($admn);
            foreach ($admn as $Avalue) {
                $itemsz3 = array(
                    'label' => $Avalue['voce'],
                    'url' => Url::toRoute($Avalue['url']),
                    //          'target' => 'self_',
                    'icon' => $Avalue['icona'],
                );

                $sbz[] = $itemsz3;
            }

            $items[] = array('label' => 'ADMIN panel',
                'icon' => 'user',
                //'items' => array(
                //'label' => 'ADMIN UTENTI', //. Yii::$app->user->id,
                //   'url' => Url::toRoute(['/user']),
                //    'target' => 'self_',
                'icon' => 'user', //$value['icona'],
                'items' => $sbz, //array('label'=>'1'),

            )
            ;

        }

        //  yii::warning(array_values(array_filter(array_unique($items, SORT_REGULAR))));
        return (array_values(array_filter(array_unique($items, SORT_REGULAR))));
    }

    public function actionContatti($render = null, $id = null)
    {


        if ($usrid !== null) {
            $ris = (new \yii\db\Query())
                ->select(['email', 'cd_cli'])
                ->from('user')
                ->where(['id' => $usrid])
                ->one();
        //->AsArray();
        
        }
        $cc = (new \yii\db\Query())
            ->select(['ccemail'])
            ->from('ana_cli')
            ->where(['cd_cli' => $ris['cd_cli']])
            ->one();
        $rcc = isset($cc['ccemail']) ? $cc['ccemail'] : '';


        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {

            $model->files = UploadedFile::getInstances($model, 'files');
            $path = Yii::getAlias('@webroot') . '/uploads/mail2/';
            $t = '';
            $atc = [];
            $atc2 = $model->files;
            foreach ($model->files as $file) {
                $file->saveAs(
                    // $t=$t.
                    ($path . $file->baseName . '.' . $file->extension));
                //.'<br>';
                //$model->path = $path . $model->files->baseName . '.' . $model->files->extension;

                $atc[] = ($path . $file->baseName . '.' . $file->extension);
            }

            $model->contact(Yii::$app->params['adminEmail'], $atc, $atc2);

//die("inviata");

            $elemail = new Elemail();
            $elemail->setAttribute('nome', $model->name);
            $elemail->setAttribute('email', $model->email.'-'.$rcc);
            $elemail->setAttribute('Soggetto', $model->subject);
            $elemail->setAttribute('Corpo', $model->body);

            $elemail->setAttribute('allegati', implode("|", $atc));
            $elemail->save(false);

            if (is_null($render) == false) {
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

            } else {
                Yii::$app->session->setFlash('contactFormSubmitted');

                return $this->refresh();
            }

        }

        if (is_null($render) == false) {
            return $this->renderajax('contatti', [
                'model' => $model,
            ]);

        } else {
            return $this->render('contatti', [
                'model' => $model,
            ]);
        }

        //return $this->render('contatti', ['model' => $model]);

    }


    public function actionReclami($render = null, $id = null)
    {


        if ($usrid !== null) {
            $ris = (new \yii\db\Query())
                ->select(['email', 'cd_cli'])
                ->from('user')
                ->where(['id' => $usrid])
                ->one();
        //->AsArray();
        
        }
        $cc = (new \yii\db\Query())
            ->select(['ccemail'])
            ->from('ana_cli')
            ->where(['cd_cli' => $ris['cd_cli']])
            ->one();
        $rcc = isset($cc['ccemail']) ? $cc['ccemail'] : '';


        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {

            $model->files = UploadedFile::getInstances($model, 'files');
            $path = Yii::getAlias('@webroot') . '/uploads/mail2/';
            $t = '';
            $atc = [];
            $atc2 = $model->files;
            foreach ($model->files as $file) {
                $file->saveAs(
                    // $t=$t.
                    ($path . $file->baseName . '.' . $file->extension));
                //.'<br>';
                //$model->path = $path . $model->files->baseName . '.' . $model->files->extension;

                $atc[] = ($path . $file->baseName . '.' . $file->extension);
            }

            $model->contact(Yii::$app->params['adminEmail'], $atc, $atc2);

//die("inviata");

            $elemail = new Elemail();
            $elemail->setAttribute('nome', $model->name);
            $elemail->setAttribute('email', $model->email.'-'.$rcc);
            $elemail->setAttribute('Soggetto', $model->subject);
            $elemail->setAttribute('Corpo', $model->body);

            $elemail->setAttribute('allegati', implode("|", $atc));
            $elemail->save(false);

            if (is_null($render) == false) {
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

            } else {
                Yii::$app->session->setFlash('contactFormSubmitted');

                return $this->refresh();
            }

        }

        if (is_null($render) == false) {
            return $this->renderajax('reclami', [
                'model' => $model,
            ]);

        } else {
            return $this->render('reclami', [
                'model' => $model,
            ]);
        }

        //return $this->render('contatti', ['model' => $model]);

    }


    public function actionOrdini($render = null, $id = null)
    {


        if ($usrid !== null) {
            $ris = (new \yii\db\Query())
                ->select(['email', 'cd_cli'])
                ->from('user')
                ->where(['id' => $usrid])
                ->one();
        //->AsArray();
        
        }
        $cc = (new \yii\db\Query())
            ->select(['ccemail'])
            ->from('ana_cli')
            ->where(['cd_cli' => $ris['cd_cli']])
            ->one();
        $rcc = isset($cc['ccemail']) ? $cc['ccemail'] : '';


        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {

            $model->files = UploadedFile::getInstances($model, 'files');
            $path = Yii::getAlias('@webroot') . '/uploads/mail2/';
            $t = '';
            $atc = [];
            $atc2 = $model->files;
            foreach ($model->files as $file) {
                $file->saveAs(
                    // $t=$t.
                    ($path . $file->baseName . '.' . $file->extension));
                //.'<br>';
                //$model->path = $path . $model->files->baseName . '.' . $model->files->extension;

                $atc[] = ($path . $file->baseName . '.' . $file->extension);
            }

            $model->contact(Yii::$app->params['adminEmail'], $atc, $atc2);

//die("inviata");

            $elemail = new Elemail();
            $elemail->setAttribute('nome', $model->name);
            $elemail->setAttribute('email', $model->email.'-'.$rcc);
            $elemail->setAttribute('Soggetto', $model->subject);
            $elemail->setAttribute('Corpo', $model->body);

            $elemail->setAttribute('allegati', implode("|", $atc));
            $elemail->save(false);

            if (is_null($render) == false) {
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

            } else {
                Yii::$app->session->setFlash('contactFormSubmitted');

                return $this->refresh();
            }

        }

        if (is_null($render) == false) {
            return $this->renderajax('ordini', [
                'model' => $model,
            ]);

        } else {
            return $this->render('ordini', [
                'model' => $model,
            ]);
        }

        //return $this->render('contatti', ['model' => $model]);

    }


    public function actionHelpdesk($render = null, $id = null)
    {


        if ($usrid !== null) {
            $ris = (new \yii\db\Query())
                ->select(['email', 'cd_cli'])
                ->from('user')
                ->where(['id' => $usrid])
                ->one();
        //->AsArray();
        
        }
        $cc = (new \yii\db\Query())
            ->select(['ccemail'])
            ->from('ana_cli')
            ->where(['cd_cli' => $ris['cd_cli']])
            ->one();
        $rcc = isset($cc['ccemail']) ? $cc['ccemail'] : '';


        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {

            $model->files = UploadedFile::getInstances($model, 'files');
            $path = Yii::getAlias('@webroot') . '/uploads/mail2/';
            $t = '';
            $atc = [];
            $atc2 = $model->files;
            foreach ($model->files as $file) {
                $file->saveAs(
                    // $t=$t.
                    ($path . $file->baseName . '.' . $file->extension));
                //.'<br>';
                //$model->path = $path . $model->files->baseName . '.' . $model->files->extension;

                $atc[] = ($path . $file->baseName . '.' . $file->extension);
            }

            $model->contact(Yii::$app->params['adminEmail'], $atc, $atc2);

//die("inviata");

            $elemail = new Elemail();
            $elemail->setAttribute('nome', $model->name);
            $elemail->setAttribute('email', $model->email.'-'.$rcc);
            $elemail->setAttribute('Soggetto', $model->subject);
            $elemail->setAttribute('Corpo', $model->body);

            $elemail->setAttribute('allegati', implode("|", $atc));
            $elemail->save(false);

            if (is_null($render) == false) {
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

            } else {
                Yii::$app->session->setFlash('contactFormSubmitted');

                return $this->refresh();
            }

        }

        if (is_null($render) == false) {
            return $this->renderajax('helpdesk', [
                'model' => $model,
            ]);

        } else {
            return $this->render('helpdesk', [
                'model' => $model,
            ]);
        }

        //return $this->render('contatti', ['model' => $model]);

    }

    public function actionRep($render = null, $id = null)
    {


       

        if (is_null($render) == false) {
            return $this->renderajax('rep', [
              //  'model' => $model,
            ]);

        } else {
            return $this->render('rep', [
                //'model' => $model,
            ]);
        }

        //return $this->render('contatti', ['model' => $model]);

    }


    public function actionGetexp()
    {

        $isFa = 'default value';
        $isFa = $isFa ?? 'default value';
        $pdfHeader = '';
        $pdfFooter = '';
        $title = null;

        $defaultExportConfig = [
            GridView::HTML => [
                'label' => Yii::t('kvgrid', 'HTML'),
                'icon' => $isFa ? 'file-text' : 'floppy-saved',
                'iconOptions' => ['class' => 'text-info'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The HTML export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Hyper Text Markup Language')],
                'mime' => 'text/html',
                'config' => [
                    'cssFile' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
                ],
            ],
            GridView::CSV => [
                'label' => Yii::t('kvgrid', 'CSV'),
                'icon' => $isFa ? 'file-code-o' : 'floppy-open',
                'iconOptions' => ['class' => 'text-primary'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The CSV export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Comma Separated Values')],
                'mime' => 'application/csv',
                'config' => [
                    'colDelimiter' => ",",
                    'rowDelimiter' => "\r\n",
                ],
            ],
            GridView::TEXT => [
                'label' => Yii::t('kvgrid', 'Text'),
                'icon' => $isFa ? 'file-text-o' : 'floppy-save',
                'iconOptions' => ['class' => 'text-muted'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The TEXT export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Tab Delimited Text')],
                'mime' => 'text/plain',
                'config' => [
                    'colDelimiter' => "\t",
                    'rowDelimiter' => "\r\n",
                ],
            ],
            GridView::EXCEL => [
                'label' => Yii::t('kvgrid', 'Excel'),
                'icon' => $isFa ? 'file-excel-o' : 'floppy-remove',
                'iconOptions' => ['class' => 'text-success'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The EXCEL export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Microsoft Excel 95+')],
                'mime' => 'application/vnd.ms-excel',
                'config' => [
                    'worksheet' => Yii::t('kvgrid', 'ExportWorksheet'),
                    'cssFile' => '',
                ],
            ],
            GridView::PDF => [
                'label' => Yii::t('kvgrid', 'PDF'),
                'icon' => $isFa ? 'file-pdf-o' : 'floppy-disk',
                'iconOptions' => ['class' => 'text-danger'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The PDF export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Portable Document Format')],
                'mime' => 'application/pdf',
                'config' => [
                    'mode' => 'c',
                    'format' => 'A4-L',
                    'destination' => 'D',
                    'marginTop' => 20,
                    'marginBottom' => 20,
                    'cssInline' => '.kv-wrap{padding:20px;}' .
                    '.kv-align-center{text-align:center;}' .
                    '.kv-align-left{text-align:left;}' .
                    '.kv-align-right{text-align:right;}' .
                    '.kv-align-top{vertical-align:top!important;}' .
                    '.kv-align-bottom{vertical-align:bottom!important;}' .
                    '.kv-align-middle{vertical-align:middle!important;}' .
                    '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
                    '.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
                    '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
                    'methods' => [
                        'SetHeader' => [
                            ['odd' => $pdfHeader, 'even' => $pdfHeader],
                        ],
                        'SetFooter' => [
                            ['odd' => $pdfFooter, 'even' => $pdfFooter],
                        ],
                    ],
                    'options' => [
                        'title' => $title,
                        'subject' => Yii::t('kvgrid', 'PDF export generated by kartik-v/yii2-grid extension'),
                        'keywords' => Yii::t('kvgrid', 'krajee, grid, export, yii2-grid, pdf'),
                    ],
                    'contentBefore' => '',
                    'contentAfter' => '',
                ],
            ],
            GridView::JSON => [
                'label' => Yii::t('kvgrid', 'JSON'),
                'icon' => $isFa ? 'file-code-o' : 'floppy-open',
                'iconOptions' => ['class' => 'text-warning'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The JSON export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'JavaScript Object Notation')],
                'mime' => 'application/json',
                'config' => [
                    'colHeads' => [],
                    'slugColHeads' => false,
                    'jsonReplacer' => null,
                    'indentSpace' => 4,
                ],
            ],
        ];
        return $defaultExportConfig;
    }
    public function actionReport()
    {
        $report = new \app\reports\_MyReport(array('cd_Cli' =>
            Yii::$app->user->identity->cd_cli,
        ));
        $report->run();
        return $this->render('report', array(
            "report" => $report,
        ));

    }
    public function actionSmail()
    {
        //  $t=Yii::$app->request->post();
        //  echo "ciao";
        // yii::warning($t);
        //  return serialize($_POST);

/*
public $name;
public $email;
public $subject;
public $body;
public $verifyCode;
public $files;
 */

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())
        ) {
            $model->files = UploadedFile::getInstance($model, 'files');
            $path = Yii::getAlias('@webroot') . '/uploads/mail/';

            $model->files->saveAs($path . $model->files->baseName . '.' . $model->files->extension);
            $model->path = $path . $model->files->baseName . '.' . $model->files->extension;
            $model->contact(Yii::$app->params['adminEmail']);
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $model->files;
            //$this->refresh();
        }
        return $this->render('contatti', [
            'model' => $model,
        ]);

    }

    public function actionAssocia()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {

            $model->files = UploadedFile::getInstances($model, 'files');
            $path = Yii::getAlias('@webroot') . '/uploads/mail2/';
            $t = '';
            $atc = [];
            $atc2 = $model->files;
            foreach ($model->files as $file) {
                $file->saveAs(
                    // $t=$t.
                    ($path . $file->baseName . '.' . $file->extension));
                //.'<br>';
                //$model->path = $path . $model->files->baseName . '.' . $model->files->extension;

                $atc[] = ($path . $file->baseName . '.' . $file->extension);
            }

            $model->contact(Yii::$app->params['adminEmail'], $atc, $atc2);

            Yii::$app->session->setFlash('contactFormSubmitted');
//die("inviata");

            $elemail = new Elemail();
            $elemail->setAttribute('nome', $model->name);
            $elemail->setAttribute('email', $model->email);
            $elemail->setAttribute('Soggetto', $model->subject);
            $elemail->setAttribute('Corpo', $model->body);

            $elemail->setAttribute('allegati', implode("|", $atc));
            $elemail->save();

            return $this->refresh();
        }
        return $this->render('associa', [
            'model' => $model,
        ]);

        //return $this->render('contatti', ['model' => $model]);

    }
    public function actionCf($id)
    {
        $model = user::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            yii::error($model->cd_cli);
            $model->save();
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

            //$this->refresh();
        }
        return $this->renderajax('cf', [
            'id' => $id, 'model' => $model,
        ]);

    }

    public function actionChat()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            $message = Yii::$app->request->post('message');

            // Esegui la logica del tuo chatbot per elaborare il messaggio e generare una risposta
            $answer = 'La risposta del tuo chatbot qui';
            yii::warning($message);
            // Reindirizza l'utente alla vista "chat" con la risposta del chatbot come parametro
            return $this->render('chat', ['answer' => $answer]);
        } else {
            // Se la richiesta non è una richiesta AJAX o non contiene dati POST, reindirizza l'utente alla pagina principale
            return $this->render('chat', ['answer' => null]);
        }
    }

}
