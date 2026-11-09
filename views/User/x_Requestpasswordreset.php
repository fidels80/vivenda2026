<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\ResetPasswordForm */
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
yii::warning('pagina');
yii::warning( $model);
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
//yii::warning(var_dump($model));
$this->title = 'Reset password';
//$this->params['breadcrumbs'][] = $this->title;
?>

<h1>asdasdasddsada</h1>
<div class="site-reset-password">
    <h1><?=Html::encode($this->title)?></h1>

    <p>Please choose your new password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'Requestpasswordreset']);?>

                <?php echo $form->field($model, 'password')->
                passwordInput(['autofocus' => true]) ;?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']);?>
                </div>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
