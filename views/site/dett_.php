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

$Eleloc=
new    ActiveDataProvider([
    'query' => Locazioni::find() ,
    'pagination' => [
        'pageSize' => 10,
    ],
]);
 
$series = [
    [
        'name' => 'Entity 1',
        'data' => [
            ['2018-10-04',4 ],
            ['2018-10-05',3 ],
        ],
    ],
    [
        'name' => 'Entity 2',
        'data' => [
            ['2018-10-04',2 ],
            ['2018-10-05',1 ],
        ],
    ],
    [
        'name' => 'Entity 3',
        'data' => [
            ['2018-10-04',3 ],
            ['2018-10-05',1 ],
        ],
    ],
    [
        'name' => 'Entity 4',
        'data' => [
            ['2018-10-04',5 ],
            ['2018-10-05',6 ],
        ],
    ],
];
/* @var $this yii\web\View */
use yii\web\JsExpression;







if (isset($_POST['filtro'])) {
    echo "Yes, filtro is set";    
} else {    
    echo "N0, filtro is not set";
}





$this->title = 'StudioS';
?>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


  <script type='text/javascript'>
      var array = []
      $(document).ready(function () {
                $('input[type="checkbox"]').click(function () {
                    if ($(this).prop("checked") == true) {
                        alert("Checkbox is checked.");
                        console.log($(this).attr("id"));
                    } else if ($(this).prop("checked") == false) {
                        alert("Checkbox is unchecked.");
                        console.log($(this).attr("id"));
                    }
                    var cs = document.querySelectorAll('input.cs:checked');
              //  console.log(cs);
              
var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

for (var i = 0; i < checkboxes.length; i++) {
  array.push(checkboxes[i].id)
}
console.log(array);
$.ajax({     url: "dett_.php",
            type: "POST",
            data: {
                'filtro[]': array
            },
            success: function () {
                console.log('sssarray');
            },
            error: function () {
                console.log('noooarray');
            }
        });
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
    $url=//str_replace('web','',Yii::$app->request->baseUrl).'modules/Warehouse';
    Url::to(['games/update' ]);
    Yii::warning($url);
$JSCode = <<<EOF
function(start, end) {
    var title = prompt('Event Title:');
    var eventData;
    if (title) {
        eventData = {
            title: title,
            start: start,
            end: end
        };
        $('#w0').fullCalendar('renderEvent', eventData, true);
    }
    $('#w0').fullCalendar('unselect');
}
EOF;

$JSDropEvent = <<<EOF
function(date) {
    //alert("Dropped on " + date.format());
    //if ($('#drop-remove').is(':checked')) {
        // if so, remove the element from the "Draggable Events" list
    //    $(this).remove();
    //}
}
EOF;

$JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {
    //alert('Event: ' + calEvent.title);
    //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
    //alert('View: ' + view.name);
    // change the border color just for fun
    //alert(window.location.href);
    //alert("http://localhost/i3q/web/index.php?r=games/update&id="+calEvent.id);
    window.open(window.location.href+'index.php?r=eventi/update&id='+calEvent.id);
    //$(this).css('border-color', 'red');
}
EOF;
    
    ?>
  
  
  <?php 
  $js = <<<JS
  function openModal(url) {
      $.get(url, {}, function (data) {
          $(".ajax_modal").remove();
          $('body').append(data);
          $(".ajax_modal").last().modal('show');
      })
  }
  JS;
  $this->registerJs($js);
  
  $renderBefore = <<<JS
  calendar.on('eventClick', function (info) {
      console.log(info)
      if (info.event.url) {
          info.jsEvent.preventDefault();
          openModal(info.event.url);
      }
  })
  JS;
  echo'<table style="width: 100%;">
  <tbody>
  <tr>
  <td style="width: 10%;" align="TOp"><table id="xlt" style="width: 100%;">
  <tr> <td>';
  $loc=Locazioni::find()    
->asArray()
->all();
yii::warning($loc);

foreach ($loc as  $value) {
/*       echo CheckboxX::widget([
        'name'=> $value['id'],
        'value'=>1,
        'options'=>['id'=>$value['id'],
    'Onchange'=>"myFunction()"
   //,
  // 'Onclick'=>"myFunction()" 
    ],
        'pluginOptions'=>['threeState'=>false,'size'=>'xs'
        ]
    ]);
    echo '<label  for="s_5" style="color:'.$value['colore'].';">'.$value['id'].'</label>';
    echo '<br>';

*/ echo Html::checkbox( $value['id'],true,  ['label'=>$value['id'] , 'id'=>$value['id']]

)  ;
echo '<br>';





}


       echo '</td></tr><tr> <td>';
echo \onmotion\apexcharts\ApexchartsWidget::widget([
    'type' => 'bar', // default area
    'height' => '400', // default 350
    'width' => '100%', // default 100%
    'chartOptions' => [
        'chart' => [
            'toolbar' => [
                'show' => true,
                'autoSelected' => 'zoom'
            ],
        ],
        'xaxis' => [
            'type' => 'datetime',
            // 'categories' => $categories,
        ],
        'plotOptions' => [
            'bar' => [
                'horizontal' => false,
                'endingShape' => 'rounded'
            ],
        ],
        'dataLabels' => [
            'enabled' => false
        ],
        'stroke' => [
            'show' => true,
            'colors' => ['transparent']
        ],
        'legend' => [
            'verticalAlign' => 'bottom',
            'horizontalAlign' => 'left',
        ],
    ],
    'series' => $series
]);

echo'</td></tr></table>';
echo'
</td>
  <td  style="width: 60%;" > ';

  echo FullCalendarWidget::widget([
    'calendarRenderBefore' => "console.log('before', calendar)",
    'calendarRenderAfter' => "console.log('after', calendar)",
    'clientOptions' => [
        // all options from fullCalendar
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
            'events' => ['/agenda/jsoncalendar'], // see FullCalendarEventsAction
        ]),
    ],
]);
  
  echo '&nbsp;</td>
  <td  style="width: 20%;"><table style="width: 100%;"><tr>';
  echo \onmotion\apexcharts\ApexchartsWidget::widget([
    'type' => 'area', // default area
    'height' => '400', // default 350
    'width' => '75%', // default 100%
    'chartOptions' => [
        'chart' => [
            'toolbar' => [
                'show' => true,
                'autoSelected' => 'zoom'
            ],
        ],
        'xaxis' => [
            'type' => 'datetime',
            // 'categories' => $categories,
        ],
        'plotOptions' => [
            'bar' => [
                'horizontal' => false,
                'endingShape' => 'rounded'
            ],
        ],
        'dataLabels' => [
            'enabled' => false
        ],
        'stroke' => [
            'show' => true,
            'colors' => ['transparent']
        ],
        'legend' => [
            'verticalAlign' => 'bottom',
            'horizontalAlign' => 'left',
        ],
    ],
    'series' => $series
]);
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
        yii::error($xseries);
       
     //unset($xseries);
   //  $xseries=array(
     //    'name'=> "Desktops",
     //'data'=> [10, 41, 35, 51, 49, 62, 69, 91, 148]
     //);
     yii::error($xseries);
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
  echo \onmotion\apexcharts\ApexchartsWidget::widget([
    'type' => 'bar', // default area
    'height' => '400', // default 350
    'width' => '100%', // default 100%
    'chartOptions' => [
        'chart' => [
            'toolbar' => [
                'show' => true,
                'autoSelected' => 'zoom',
            ],
        ],
        'xaxis' => [
            'type' => 'datetime',
            // 'categories' => $categories,
        ],
        'plotOptions' => [
            'bar' => [
                'horizontal' => true,
            //    'endingShape' => 'rounded'
            ],
        ],/*
        'dataLabels' => [
            'enabled' => false
        ],
        'stroke' => [
            'show' => true,
            'colors' => ['transparent']
        ],
        'legend' => [
            'verticalAlign' => 'bottom',
            'horizontalAlign' => 'left',
        ],*/
    ],
    'series' => $series
]);
  echo'</tr></table></td>
  </tr>
  </tbody>
  </table>';
 
  
  
  
  ?>

