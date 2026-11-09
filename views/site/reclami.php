<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\User;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Doc_head;

$usrid = Yii::$app->user->Id;
if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['email'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
}

$ajax = 0;
$request = Yii::$app->request;

$get = $request->get();


$grid = []; //array('id'=>'default','name'=>'default');
$grid[] = array('id' => 'Richiesta Preventivo', 'Name' => 'Richiesta Preventivo');
$grid[] = array('id' => 'Domanda Amministrativa', 'Name' => 'Domanda Amministrativa');
$grid[] = array('id' => 'Richiesta di ricontatto', 'Name' => 'Richiesta di ricontatto');
$grid[] = array('id' => 'Problematica Portale', 'Name' => 'Problematica Portale');
$grid[] = array('id' => 'Problematica Pubblicazione', 'Name' => 'Problematica Pubblicazione');
$grid[] = array('id' => 'Richiedi Associazione', 'Name' => 'Richiedi Associazione');
$grid[] = array('id' => 'Reclami', 'Name' => 'Reclami');

$grid[] = array('id' => 'Altro', 'Name' => 'Altro');
if (isset($get['id'])) {
    yii::error($get['id']);
    //echo $get['id'];
    $ajax = 1;
    $grid[] = array('id' => 'Supporto Documento', 'Name' => 'Supporto Documento');
    $doc= Doc_head::find()->where(['xid_testa'=>$get['id']])->AsArray()->one();

}
else {
    yii::error('no');

}

$grid2 = ArrayHelper::map($grid, 'id', 'Name');

if ($ajax == 1) {
    $this->title = 'Richiedi Supporto Documento'.$doc['data'];

} else {
    $this->title = 'Reclami';
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
          Grazie per averci contattato , ti risponderemo nel più breve tempo possibile.
          Una copia della tua richiesta ti è stata inviata per email.
        </div>

        <p>

            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?=Yii::getAlias(Yii::$app->mailer->fileTransportPath)?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif;?>
        </p>

    <?php else: ?>
<?php 
    
   

 
    
    ?>

  <?php if ($ajax == 1): ?>

      <p>
 Richiesta di supporto per il documento 
    </p>
    <?php else: ?>
        <p>
 Se Volete segnalarci un eventuale reclamo,
  compilate il seguente modulo.
    </p><p>Grazie.
        </p>
        </p>
    <?php endif;?>



        <div class="row">
            <div class="col-lg-8">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']);?>

                    <?=$form->field($model, 'name')->textInput(['autofocus' => true])->label('Il tuo Nome', ['class' => 'label-class'])?>

                    <?=$form->field($model, 'email')->textInput(['autofocus' => true, 'value' => $ris['email']]);?>

                    <?php
$ra = $request->get('RA');

if (isset($ra)) {
    echo $form->field($model, 'subject')->
        widget(Select2::classname(), [
        'data' => $grid2,
        'options' => ['placeholder' => 'Seleziona Oggetto', 'value' => 'Richiedi Associazione'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Oggetto');
}
elseif((isset($get['id']))){

echo $form->field($model, 'subject')->
    widget(Select2::classname(), [
    'data' => $grid2,
    'options' => ['placeholder' => 'Seleziona Oggetto', 'value' => 'Supporto Documento'],
    'pluginOptions' => [
        'allowClear' => true,
    ],
])->label('Oggetto');


} else {

    echo $form->field($model, 'subject')->
        widget(Select2::classname(), [
        'data' => $grid2,
        'options' => ['placeholder' => 'Seleziona Oggetto', 'value' => 'Reclami'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Oggetto');}?>



                    <?=$form->field($model, 'body')->textarea(['rows' => 6])->label('Richiesta', ['class' => 'label-class'])?>

<?=$form->field($model, 'files[]')->fileInput(['multiple' => true])?>

                    <?=$form->field($model, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
])->label('Non sei un robot', ['class' => 'label-class'])?>

                    <div class="form-group">
                        <?=Html::submitButton('Manda Email', ['Contatti', 'class' => 'btn btn-primary', 'name' => 'contact-button'])?>
                    </div>

                <?php ActiveForm::end();?>

            </div>
        </div>

    <?php endif;?>
</div>
