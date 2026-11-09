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

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\usrgrp;
use app\models\xmenu;
use app\models\xsubmenu;
use app\models\Anacli;
use dosamigos\fileupload\FileUploadui;
use app\models\user;
 



 
 
 
$xids=user::find()->select('cd_cli')
->distinct()->all()  ;
 //$ids=implode(",", $xids);
$ids=[];
 foreach ($xids as  $value) {
if (!is_null($value['cd_cli'])) {
    $ids[]= $value['cd_cli'];
}
}

yii::warning($ids);
$cli= Anacli::find()
->select(['cd_cli as id','Desk as Name'])
->where(['in','cd_cli',$ids]) 
->andwhere(['not in','cd_cli','C001443'])
 ->asArray()
->all();
yii::warning($cli);
$lstcli=ArrayHelper::map($cli,'id','Name');





?>

 

  
 

    <?php $form = ActiveForm::begin();?>
<div class="card card-danger">
<div class="card-header">
<h3 class="card-title">Cambio Azienda</h3>
</div>

 <?php  
 

 

//echo '<br><h3>status a 10 per attivazione utenza</h3><br>';

 
echo $form->field($model, 'cd_cli', ['enableClientValidation' => true])->
    widget(Select2::classname(), [
    'data' => $lstcli,

    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona Cliente ...',

    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]);

 


 
?>

</div>
<div class="card-footer">
</div>
</div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

 
    
 </div>
<?php ActiveForm::end();
