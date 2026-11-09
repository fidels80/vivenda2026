<?php
use   kartik\depdrop\DepDrop; 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\controllers\RelusrformactionController;
use kartik\select2\Select2;
use app\models\User;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Relusrformaction */
/* @var $form yii\widgets\ActiveForm */
$t=RelusrformactionController::Getcontroller();
$perms=array_keys($t)    ;
$perms=str_replace('Controller', '', $perms);

$result = ArrayHelper::index($perms, 'id');

$result=[];
foreach( $perms as $valore)  
   {  
    //[$valore=$valore];  
   //array_push($result,$valore=$valore);
   $result[$valore] = $valore;
     //$fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
   }  
 



yii::warning($result);
$brd = user::find()
        ->select(['id as id', 'username as  Name'])
        ->asArray()
        ->all();
$listusr = ArrayHelper::map($brd, 'id', 'Name');
$datac []=('index');
?>

<div class="relusrformaction-form">

  
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'id_user')->widget(Select2::classname(), ['name' => 'usr', 'data' => $listusr,
                            'options' => ['placeholder' => 'Seleziona utente ...',],
                            'pluginOptions' => [
                                'allowClear' => false,
                                'disabled'=>false,
                            ],
                        ])->label('utenti'); ?>

    <?= $form->field($model, 'form')->widget(Select2::classname(), ['name' => 'frm', 'data' => $result,
                            'options' => ['placeholder' => 'Seleziona form ...','id' => 'lvl-0'],
                            'pluginOptions' => [
                                'allowClear' => false,
                                'disabled'=>false,
                            ],
                        ])->label('Forms'); ?>

    
     <?= $form->field($model, 'azione')-> widget(DepDrop::classname(), [
                'data' => $datac,
                'options' => ['placeholder' => 'carico ...'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => true],'value' =>[$model->form]],
                'pluginOptions' => [
                    'depends' => ['lvl-0'],
                    'url' => Url::to(['/relusrformaction/list']),
                    //   'params' => ['lvl-0'],
                    'loadingText' => 'caricamento dati ...',
                ]
            ]);
    ?>
    <?= $form->field($model, 'read')->checkbox() ?>

    <?= $form->field($model, 'write')->checkbox() ?>

    <?= $form->field($model, 'delete')->checkbox() ?>

    <?= $form->field($model, 'access')->checkbox() ?>
  <?= $form->field($model, 'level')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 