<?php
use yii\helpers\Html;
use app\models\Agenda;
use yii\widgets\ActiveForm;
use philippfrenzel\yii2fullcalendar;
use philippfrenzel\yii2fullcalendarscheduler;
use yii\helpers\Url;
use app\models\Locazioni;
use kriss\calendarSchedule\widgets\FullCalendarWidget;
use kriss\calendarSchedule\widgets\processors\EventProcessor;
use kriss\calendarSchedule\widgets\processors\HeaderToolbarProcessor;
use kriss\calendarSchedule\widgets\processors\LocaleProcessor;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use kriss\calendarSchedule\CalendarScheduleWidget;
use  yii\widget;
use yii\helpers\ArrayHelper;
use kartik\checkbox\CheckboxX;

 
/* @var $this yii\web\View */
use yii\web\JsExpression;



yii::warning(Url::home(true));


if( isset($filtro) ){
  $filtro2=implode(',',$filtro);
 // echo $filtro2;
  //exit;
 }else {
  // echo 'nonva';
 }




$this->title = 'StudioS';
?>



  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


  <script type='text/javascript'>
      var array = []
      $(document).ready(function () {
        $('#xfiltro2').prop('action','');
                $('input[type="checkbox"]').click(function (e) {
               
                    if ($(this).prop("checked") == true) {
                        //alert("Checkbox is checked.");
                        //$('#calendar').fullCalendar('removeEvents');
                       


                    } else if ($(this).prop("checked") == false) {
                      //  alert("Checkbox is unchecked.");
                    //    console.log($(this).attr("id"));
                    }
                    var cs = document.querySelectorAll('input.cs:checked');
              //  console.log(cs);
              
var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
filtro = [];
for (var i = 0; i < checkboxes.length; i++) {
  filtro.push(checkboxes[i].id)
}
//var jsonString = JSON.stringify(filtro);
text = filtro.toString();
document.getElementById('filtro').value='';
document.getElementById('filtro').value=filtro;
console.log(text);

$('#xfiltro2').prop('action',  '<?php echo Url::home(true)?>'
+'index.php?r=agenda/selcal&filtro='+text);
 ;
 $('#fbutt').click(); 
                });
            

            });
        </script> 
<script>   
  
 

 </script>

<div class="site-index">
<div align='center'>
</div><br>
<br>

<?php 
$events = array();
  $times = Agenda::find()
  ->all();

    $events = array();

 

 

  $JSEventClick = new \yii\web\JsExpression(
    "console.log('event')"
);

  ?>
  

 
  
  <?php 

  echo'<table style="width: 100%;">
  <tbody>
  <tr>
  <td style="width: 10%; vertical-align:top"  ><table id="xlt" style="width: 100%;" class="align-top">
  <tr> <td  >';
  $loc=Locazioni::find()    
->asArray()
->all();
//yii::warning($loc);

foreach ($loc as  $value) {

 if (empty($filtro)==true){

  echo Html::checkbox($value['id'], true, ['label'=>$value['id'] ,
  'id'=>$value['id'],'checked'=>true]);
 }
else{
    if (in_array($value['id'], $filtro)==false) {
        echo Html::checkbox($value['id'], true, ['label'=>$value['id'] ,
     'id'=>$value['id'],'checked'=>false]);
    } else {
        echo Html::checkbox($value['id'], true, ['label'=>$value['id'] ,
       'id'=>$value['id'],'checked'=>true]);
    }
}

  echo '<br>';





}
//echo Html::checkbox('ultimo', true, [  'id'=>'ultimo','checked'=>true]);
?>
<?= Html::beginForm(['/index'], 'POST',['id'=>'xfiltro2']);  
echo html::textInput('filtro','filtro',$options=['id'=>'filtro','hidden'=>true ]);
?>
 
<div class="form-group">
    <?= Html::submitButton('Filtra', ['class' => 'btn btn-primary','id'=>'fbutt','style'=>"display: none;"]); ?>
</div>
<?= Html::endForm(); ?>
   <?php    echo '</td></tr><tr> <td>';

echo'</td></tr></table>';
echo'
</td>
  <td  style="width: 80%;" > ';
 
  echo FullCalendarWidget::widget([
    'calendarRenderBefore' => "console.log('before', calendar);calendar.id='CALENDARIO'",
    'calendarRenderAfter' => "console.log('after', calendar);calendar.id='CALENDARIO'",
    'clientOptions' => [
        // all options from fullCalendar
        'height'=> 700,
        'dayMaxEvents'=>true
         
    ],
    'processors' => [
        // quick solve fullCalendar options
        new LocaleProcessor([
            'locale' => 'it',
        ]),
        new HeaderToolbarProcessor(),
        new EventProcessor([
            // use Array
            /*'events' => [
                ['title' => 'aaa', 'start' => time(), 'end' => time() + 10 * 3600],
            ],*/
            // use Ajax
            'events' => ['/agenda/jsoncalendar','filtro'=>$filtro2], // see FullCalendarEventsAction
        ]),
    ],
]);



 

  
  echo '&nbsp;</td>
  <td  style="width: 10%;"><table style="width: 100%;"><tr>';
  
  echo'</tr><tr>';
/*
  series: [
    {
      data: [
        {
          x: 'Code',
          y: [
            new Date('2019-03-02').getTime(),
            new Date('2019-03-04').getTime()
          ]
        },
*/
  $x='x';
  $y='y';
  
       $xseries=array('data'=>array());
        $tmpcol=Agenda::find()->asArray()->all();
      //  yii::error($tmpcol);
        foreach ($tmpcol as $value) {
            $data=array(
                'x'=>$value['elemento'],
                 'y'=>[$value['dadata'],$value['adata']]   
            ); 
           array_push( $xseries['data'],$data);
          //  yii::error($value);
        }
      //  yii::error($xseries);
       
     //unset($xseries);
   //  $xseries=array(
     //    'name'=> "Desktops",
     //'data'=> [10, 41, 35, 51, 49, 62, 69, 91, 148]
     //);
    // yii::error($xseries);
     /*$Event=array('id'=>$id,
  'title'=>$title,
  'start'=>$start,
  'end'=>$end,
  'overlap'=>$overlap,
  'startEditable'=>$startEditable,
  'allDay'=>$allDay,
  'color'=>$tmpcol->colore,
  'url' => Url::to(['site/event-detail/id='.$id])
*/
 
  echo'</tr></table></td>
  </tr>
  </tbody>
  </table>';
 
  
  
  
  ?>

 