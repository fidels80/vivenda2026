<div class="container">
  <div class="row">
    <div class="col-">
<?php
use app\models\doc_head;
use app\models\payments;
use practically\chartjs\Chart;
$cf = Yii::$app->user->identity->cd_cli;
$totdoc = doc_head::find()->where(['cd_cli' => $cf])->count();
$totdocC = doc_head::find()->where(['confermato' => 1, 'cd_cli' => $cf])->count();
$totsc = payments::find()->where(['cd_cli' => $cf])->count();
$totsc_pagata = payments::find()->where(['cd_cli' => $cf, 'Pagata' => '1'])->count();
$dapagare = payments::find()->where(['cd_cli' => $cf, 'Pagata' => '0'])->sum('ImportoV');
$pagato = payments::find()->where(['cd_cli' => $cf, 'Pagata' => '1'])->sum('ImportoV');

$series = [
    [
        'name' => 'Entity 1',
        'data' => [
            ['2018-10-04', 4.66],
            ['2018-10-05', 5.0],
        ],
    ],
    [
        'name' => 'Entity 2',
        'data' => [
            ['2018-10-04', 3.88],
            ['2018-10-05', 3.77],
              ['2018-10-04', 5.66],
        ],
    ],
    [
        'name' => 'Entity 3',
        'data' => [
            ['2018-10-04', 4.40],
            ['2018-10-05', 5.0],
        ],
    ],
    [
        'name' => 'Entity 4',
        'data' => [
            ['2018-10-04', 4.5],
            ['2018-10-05', 4.18],
        ],
    ],
];


$series=[


[
                'name'=> "Desktops",
            'data'=> [45,46,1,3,0,0,0,0,0,1,1,1]
]

];

$connection = Yii::$app->getDb();
$command = $connection->createCommand("select mese,sum(tot)as tot from (
select month(DataScadenza) as mese ,sum(importov) as tot from payments 
where cd_cli=:id_cli /*and year(DataScadenza)=2022 */and pagata=1
group by year(DataScadenza),month(DataScadenza)
union
select 1 as mese,0
union
select 2 as mese,0
union
select 3 as mese,0
union
select 4 as mese,0
union
select 5 as mese,0
union
select 6 as mese,0
union
select 7 as mese,0
union
select 8 as mese,0
union
select 9 as mese,0
union
select 10 as mese,0
union
select 11 as mese,0
union
select 12 as mese,0
) as t
group by mese 

", [':id_cli' => $cf ]);

$result = $command->queryAll();



$command2 = $connection->createCommand("select mese,sum(tot)as tot from (
select month(DataScadenza) as mese ,sum(importov) as tot from payments
where cd_cli=:id_cli /*and year(DataScadenza)=2022*/ and pagata<>1
group by year(DataScadenza),month(DataScadenza)
union
select 1 as mese,0
union
select 2 as mese,0
union
select 3 as mese,0
union
select 4 as mese,0
union
select 5 as mese,0
union
select 6 as mese,0
union
select 7 as mese,0
union
select 8 as mese,0
union
select 9 as mese,0
union
select 10 as mese,0
union
select 11 as mese,0
union
select 12 as mese,0
) as t
group by mese

", [':id_cli' => $cf]);
$result2 = $command2->queryAll();
$righe=[];
$righe2 = [];
foreach ($result as  $value) {
    $righe[]=$value['tot'];
}
foreach ($result2 as $value) {
    $righe2[] = $value['tot'];
}


$series=[


[
                'name'=> "Pagate",
            'data'=>$righe //[45,46,1,3,0,0,0,0,0,1,1,1]
],
[
'name'=>'non Pagate',
          'data'=>$righe2

]

]
;
 
yii::warning($series);

 


echo \onmotion\apexcharts\ApexchartsWidget::widget([
    'type' => 'line', // default area
    'height' => '300', // default 350
    'width' => '350', // default 100%
    'chartOptions' => [
        'chart' => [
            'toolbar' => [
                'show' => true,
                'autoSelected' => 'zoom',
            ],
        ],
        'xaxis' => [
         //   'type' => 'datetime',
            // 'categories' => $categories,
       'categories'=> ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','oct','nov','dec'],
        
        ],
        'plotOptions' => [
            'bar' => [
                'horizontal' => false,
                'endingShape' => 'rounded',
            ],
        ],
        'dataLabels' => [
            'enabled' => false,
        ],
        'stroke' => [
            'show' => true,
           // 'colors' => ['transparent'],
        ],
        'legend' => [
            'verticalAlign' => 'bottom',
            'horizontalAlign' => 'left',
        ],
    ],
    'series' => $series,
]);
echo'</div><div class="col-">';
echo \onmotion\apexcharts\ApexchartsWidget::widget([
    'type' => 'bar', // default area
    'height' => '350', // default 350
    'width' => '350', // default 100%
    'chartOptions' => [
        'chart' => [
            'toolbar' => [
                'show' => true,
                'autoSelected' => 'zoom',
            ],
        ],
        'xaxis' => [
            //   'type' => 'datetime',
            // 'categories' => $categories,
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','oct','nov','dec'],

        ],
        'plotOptions' => [
            'bar' => [
                'horizontal' => true,
                'endingShape' => 'rounded',
            ],
        ],
        'dataLabels' => [
            'enabled' => true,
        ],
        'stroke' => [
            'show' => true,
             'colors' => ['transparent'],
        ],
        'legend' => [
            'verticalAlign' => 'bottom',
            'horizontalAlign' => 'left',
        ],
    ],
    'series' => $series,
]);
echo '</div><div class="col-">';

//yii::warning($series);

$command3 = $connection->createCommand("select cd_doc as x,
 count(*)as y
 from doc_head where cd_cli=:id_cli
group by cd_doc",[':id_cli' => $cf ]);
$result3 = $command3->queryAll();

        $Rseries= [
          
            'data'=> [
              
              [  'x'=> 'New Delhi',
                'y'=> 218
            ],
             [   'x'=> 'Kolkata',
                'y'=> 149
        ],]];


$xseries = [

    //[
     //   'name' => "Pagate",
        'data' => $result3, //[45,46,1,3,0,0,0,0,0,1,1,1]
    //],
    //[
    //    'name' => 'non Pagate',
    //    'data' => $righe2,

   // ],

]
;

$xseria1=[];
 $data[]=$result3;

$xseria1[]=['data'=>$result3];

yii::warning($xseria1);

$pippo= array('data'=>[
    ['x'=>'a',
    'y'=>10
],
    ['x'=>'b',
    'y'=>20
],  ['x'=>'c',
    'y'=>30
],  ['x'=>'d',
    'y'=>40
],  ['x'=>'e',
    'y'=>50
],  
    
    
    
    
    ]




);
yii::warning($pippo);

echo \onmotion\apexcharts\ApexchartsWidget::widget([
    'type' => 'radar', // default area
    'height' => '350', // default 350
    'width' => '350', // default 100%
    'chartOptions' => [
        'chart' => [
            'toolbar' => [
                'show' => true,
                'autoSelected' => 'zoom',
            ],
        ],
        'xaxis' => [
            //   'type' => 'datetime',
            // 'categories' => $categories,
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','oct','nov','dec'],

        ],
        'plotOptions' => [
            'bar' => [
                'horizontal' => true,
                'endingShape' => 'rounded',
            ],
        ],
        'dataLabels' => [
            'enabled' => true,
        ],
        'stroke' => [
            'show' => true,
            'colors' => ['transparent'],
        ],
        'legend' => [
            'verticalAlign' => 'bottom',
            'horizontalAlign' => 'left',
        ],
    ],
    'series' => $series,
]);


?>
</div></div></div>
  var options = {
          series: [
          {
            data: [
              {
                x: 'New Delhi',
                y: 218
              },
              {
                x: 'Kolkata',
                y: 149
              },
              {
                x: 'Mumbai',
                y: 184
              },
              {
                x: 'Ahmedabad',
                y: 55
              },
              {
                x: 'Bangaluru',
                y: 84
              },
              {
                x: 'Pune',
                y: 31
              },
              {
                x: 'Chennai',
                y: 70
              },
              {
                x: 'Jaipur',
                y: 30
              },
              {
                x: 'Surat',
                y: 44
              },
              {
                x: 'Hyderabad',
                y: 68
              },
              {
                x: 'Lucknow',
                y: 28
              },
              {
                x: 'Indore',
                y: 19
              },
              {
                x: 'Kanpur',
                y: 29
              }
            ]
          }
        ],
          legend: {
          show: false
        },
        chart: {
          height: 350,
          type: 'treemap'
        },
        title: {
          text: 'Basic Treemap'
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      

        <?php
        echo \onmotion\apexcharts\ApexchartsWidget::widget([
    'type' => 'bar', // default area
    'height' => '400', // default 350
    'width' => '500', // default 100%
    'chartOptions' => [
        'chart' => [
            'toolbar' => [
                'show' => true,
                'autoSelected' => 'zoom',
            ],
        ],
        'xaxis' => [
            //'type' => 'datetime',
            // 'categories' => $categories,
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','oct','nov','dec'],

        ],
        'plotOptions' => [
            'bar' => [
                'horizontal' => false,
                'endingShape' => 'rounded',
            ],
        ],
        'dataLabels' => [
            'enabled' => false,
        ],
        'stroke' => [
            'show' => true,
            'colors' => ['transparent'],
        ],
        'legend' => [
            'verticalAlign' => 'bottom',
            'horizontalAlign' => 'left',
        ],
    ],
    'series' => $series,
]);
?>