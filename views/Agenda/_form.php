<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\locazioni;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;
use app\models\AgendaFiles;
use app\models\Agenda;
use yii\helpers\Url;
use  yii\bootstrap4\Modal;
$loc=Locazioni::find()    
  ->select(['id as id', 'descrizione as  Name'])
->asArray()
->all();
$locstplt = ArrayHelper::map($loc, 'id', 'Name');
/* @var $this yii\web\View */
/* @var $model app\models\Agenda */
/* @var $form yii\widgets\ActiveForm */

 
?>

<div class="agenda-form">

    <?php $form = ActiveForm::begin([ 'enableClientValidation' => false,]); ?>

    
    <?= $form->field($model->Agenda, 'dadata')->widget(DateTimePicker::classname(), [
        'size' => 'lg',
    'options' => ['placeholder' => 'Seleziona Data di Inizio ...'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd/mm/yyyy hh:ii'
    ]
]); ?>

    <?= $form->field($model->Agenda, 'adata')->widget(DateTimePicker::classname(), [
    'size' => 'lg',
    'options' => ['placeholder' => 'Seleziona Data di fine  ...'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd/mm/yyyy hh:ii'
    ]
]); ?>

    <?= $form->field($model->Agenda, 'elemento')->widget(Select2::classname(), [
    'data' => $locstplt,
    'size' => 'lg',
    'options' => ['placeholder' => 'seleziona locazione ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>

<?= $form->field($model->Agenda,'descrizione')->textInput() ?>
<?= $form->field($model->Agenda,'nota')->textarea(['rows' => '5']) ?>
 
<?php


$tmpid=0;
Modal::begin([
  //'header'=>'<h4>Clienti</h4>',
  'id' => 'cli'.$tmpid,
  'size'=>'modal-lg', //classe bootstrap
  ]);
  echo "<div id='modalContent'></div>";
  Modal::end();               
  $this->registerJs( "
  $('#modalcli_$tmpid').click(function (){
  $('#cli$tmpid').modal('show')
  .find('#modalContent')
  .load($(this).attr('value'));
  });"
   );
   $url=Url::to(['agendafiles/createaj','idagenda' => $model->Agenda->id]);
   echo Html::button('Carica File',['value'=>$url,
   'class' => 'btn btn-success','id'=>'modalcli_'.$tmpid]);






?>

        <?php
      //  yii::warning("<pre>".print_r($model,true)."</pre>");
        // parcel table
        $AF = new AgendaFiles();
        $AF->loadDefaultValues();
        echo '<table id="product-parcels" class="table table-condensed table-bordered">';
        echo '<thead>';
        echo '<tr>';
      //  echo '<th>' . $AF->getAttributeLabel('id_agenda') . '</th>';
        echo '<th>' . $AF->getAttributeLabel('descrizione') . '</th>';
        echo '<th>' . $AF->getAttributeLabel('Nota') . '</th>';
        echo '<th>' . $AF->getAttributeLabel('nome_file') . '</th>';
        echo '<th>' . $AF->getAttributeLabel('estensione') . '</th>';
        echo '<th>Scarica</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        // existing parcels fields
      //   try {
        foreach ($model-> Files as $value) {
          echo '<tr>';
         // echo  '<td>';
        //  echo $value['id_agenda'];
        //  echo '</td>';
          echo  '<td>';
          echo $value['descrizione'];
          echo '</td>';
          echo  '<td>';
          echo $value['nota'];
          echo '</td>';
          echo  '<td>';
          echo $value['nome_file'];
          echo '</td>';
          echo  '<td>';
          echo $value['estenzione'];
          echo '</td>';
          echo  '<td>';
          echo  Html::a('scarica',['agenda_files/genfile','id' => $value['id'],'file'=>str_replace(' ', '_',$value['nome_file']) ]);
          //'<a  href="'.$value['id_agenda'].'_'.$value['nome_file'].'">scarica</a>';
          echo '</td>';
         
          echo '</tr>';
         
          /*$form->field($parcel, 'code')->textInput([
              'id' => "Parcels_{$key}_code",
              'name' => "Parcels[$key][code]",
          ])->label(false)  */
          

        //  yii::warning(  "<pre>".print_r($value,true)."</pre>");
         // echo $value['nota'].'</tr>';
       }
        
        // new parcel fields
        echo '<tr id="product-new-parcel-block" style="display: none;">';
     /*   echo $this->render('_form-product-parcel', [
            'key' => '__id__',
            'form' => $form,
            'Agendafile' => $_af,
        ]);
        */echo '</tr>';
        echo '</tbody>';
        echo '</table>';
   // } catch (Exception $e) {
    //    echo 'Caught exception: ',  $e->getMessage(), "\n";
    //}
        // OPTIONAL: register JS assets as required for widgets
       // \zhuravljov\widgets\DatePickerAsset::register($this);
       // \kartik\select2\Select2Asset::register($this);
       // \yii\jui\JuiAsset::register($this);
        ?>













<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
