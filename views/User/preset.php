<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\ResetPasswordForm */
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
yii::warning('pagina');
//yii::warning($model);
//use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
//echo "cane";

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Request password reset</title>
    <meta name="csrf-param" content="_csrf">
<meta name="csrf-token" content="Lz33SG3qGpqUR2qXUTRyTJxRV9z4XLWBpbnsTbYGFa8WXrB6FLBOzuIMPOYUXx17yAY4qos_4MPtjZsu_it92w==">

<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback" rel="stylesheet">
<link href="/dcal/web/assets/e870f8c7/css/all.min.css" rel="stylesheet">
<link href="/dcal/web/assets/9b60aaed/css/bootstrap.css" rel="stylesheet">
<link href="/dcal/web/assets/52997302/css/adminlte.min.css" rel="stylesheet"></head>
<body class="hold-transition sidebar-mini">
     <script type="text/javascript" src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#password2').focusout(function(){
        var pass = $('#password').val();
        var pass2 = $('#password2').val();
        if(pass != pass2){
            alert('le password non sono uguali!');
        }

    });
});
       </script> 
    <div class="wrapper">
    <table width="80%">
<tbody>
<tr>
        <td style="width: 30%;">&nbsp;</td>
<td style="width: 60%;">
<div class="site-reset-password">
    <h1><?=Html::encode($this->title)?></h1>

    <p>Please choose your new password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']);?>

                <?=$form->field($model, 'password')->passwordInput(['id' => 'password','autofocus' => true])?>
                <?=$form->field($model, 'password')->passwordInput(['id' => 'password2','autofocus' => true])?>

                
                
                <div class="form-group">
                    <?=Html::submitButton('Save', ['class' => 'btn btn-primary'])?>
                </div>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
&nbsp;</td>
<td style="width: 30%;">&nbsp;</td>
</tr>
</tbody>
</table>
    
</div>