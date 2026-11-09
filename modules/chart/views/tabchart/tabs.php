<?php 
 use yii\helpers\Html;
 use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView as kgrid;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;



$js= Yii::$app->controller->module->registerJSS('scripts.js'); 
     $this->registerJsFile($js);  




//echo $tab;
//print_R( $pk);


$m=
    ['label'=>'M',
    'format'=>'html',
        'value' =>
        function($data) use( $tab,$pk) {

            foreach($data as $key => $value) {
                //echo "$key is at $value";
               // echo $form->field($data, $key)->textInput();
            if ($key==$pk){
            $recid=$value;
            } 
            }


            return Html::a('Modifica', ['dtab/edit', 'pk' =>$pk,'tab'=>$tab,'data'=>$data,'recid'=> $recid],['class'=>'btn btn-warning']);
        }
        ]
   
;
$d=
    ['label'=>'D',
    'format'=>'raw',
        'value' =>
        function($data) use( $tab,$pk)  {
            foreach($data as $key => $value) {
                //echo "$key is at $value";
               // echo $form->field($data, $key)->textInput();
            if ($key==$pk){
            $recid=$value;
            } 
            }
            $tmpid=$recid;
            $url=//str_replace('web','',Yii::$app->request->baseUrl).'modules/Warehouse';
            Url::to(['dtab/del', 'pk' =>$pk,'tab'=>$tab,/*'data'=>$data,*/'recid'=> $recid]);
            $this->registerJs( "
            $('#modaldoc_$tmpid').click(function (){
                if (confirm('il dato sta per essere cancellato!!!')) {
                    // Save it!
                    console.log('Thing was saved to the database.');
                     // window.open('$url');
                     window.location.href='$url';
                     //  var link= document.getElementById('modaldoc_$tmpid']);
                    //  console.log(link);
                    //  link.setAttribute('href', '');
                  } else {
                    // Do nothing!
                    console.log('Thing was not saved to the database.');
                  }
            });"
             );

            return //Html::a('Cancella', ['dtab/doform',  'tab'=>$tab,/*'data'=>$data,*/ ],  [
            //'class' => 'btn btn-danger','id'=>'modaldoc_'.$tmpid]
            Html::button('Cancella', ['class' => 'btn btn-danger', 'id'=>'modaldoc_'.$tmpid]);
       
        }
        ]
   
;
 

//print_r(($columns));
//array_push($columns,['class' => 'yii\grid\SerialColumn']);
array_push($columns, $m);
array_push($columns, $d);
 
  echo   Html::a('crea', ['dtab/newdata', 'pk' =>$pk,'tab'=>$tab,/*'data'=>$data,'recid'=> $recid*/],[
    'class' => 'btn btn-success']);?>
 
 
 <input  id='search' class="form-control mr-sm-2" name="q" type="text" placeholder="Search"
    aria-label="Search">
<button class="btn btn-outline-success my-2 my-sm-0" onclick="finds();" >Search</button>
<button onclick="resets();" class="btn btn-outline-secondary ml-2">RESET</button>







<?php 
   // $searchModel = $model->search(Yii::$app->request->queryParams);
echo GridView::widget([
    'dataProvider' => $model,
  //  'filterModel' => true,
  
   'columns'=>  
            // ['class' => 'yii\grid\SerialColumn'],
   $columns ,
   
   
   
    ])


 ?>


<?php 
/*
echo  \yii\bootstrap\Tabs::widget([
    'items' => [
        [
            'label' => 'One',
            'content' => 'Anim pariatur cliche...',
            'active' => true
        ],
        [
            'label' => 'Two',
            'content' => 'Anim pariatur cliche...',
            //'headerOptions' => [...],
            'options' => ['id' => 'myveryownID'],
        ],
        [
            'label' => 'Example',
            'url' => 'http://www.example.com',
        ],
        [
            'label' => 'Dropdown',
            'items' => [
                 [
                     'label' => 'DropdownA',
                     'content' => GridView::widget([
                        'dataProvider' => $model,
                       'columns'=>  
                                // ['class' => 'yii\grid\SerialColumn'],
                       $columns ,
                       
                       
                       
                        ])
                    ,
                 ],
                 [
                     'label' => 'DropdownB',
                     'content' => 'DropdownB, Anim pariatur cliche...',
                 ],
                 [
                     'label' => 'External Link',
                     'url' => 'http://www.example.com',
                 ],
            ],
        ],
    ],
]);*/
?>