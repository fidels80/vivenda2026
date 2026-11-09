<?php 
 use yii\helpers\Html;
 use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView as kgrid;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
$connection = Yii::$app->db;//get connection
        $dbSchema = $connection->schema;
        //or $connection->getSchema();
        $tables = $dbSchema->getTableNames();

$js= Yii::$app->controller->module->registerJSS('scripts.js'); 
     $this->registerJsFile($js);  

     $page=$this;
   $t=  $page->context->Doform('mock_cars');
echo "ciao";
echo"</br>";
echo Select2::widget([ 
    'name' => 'seltabs',
    'id'=>'seltabs',
    'data' => $tables,
'options' => ['placeholder' => 'Seleziona valore ...',],
]);

?>
<button class="btn btn-outline-success my-2 my-sm-0" onclick="addtab();" >aggiungitab</button>
<button class="btn btn-outline-success my-2 my-sm-0" onclick="addtabc();" >aggiungiwhiitmem</button>
<div id='tabs'>
<?php 
echo"</br>";
echo \yii\bootstrap\Tabs::widget(['id'=>'Mtabs',
    'items' => [
        [
            'label' => 'One',
            'content' => 'Anim pariatur cliche...',
            'active' => true
        ],
        [
            'label' => 'render tabs',
            //'@app/modules/forum/views/default/index'
             'content' =>  
             $this->renderajax('tabs',[ 'model'=>$t['model'],
             'tab'=> $t['tab'],
             'fieldz'=>$t['fieldz'],
             'columns' => $t['columns'],
             'pk'=>$t['pk']])
             //  $this->renderajax('doform',
           //$this->runAction('doform' ,
          // ['tab' => 'mock_cars',
             //'pk'=>'id',
             //$this->renderAjax('@app/modules/dintable/views/default/index', [
               // 'tab' => 'mock_cars'
               //'id'=>2,
                
           // ])
           ,
           
            'options' => ['id' => 'myveryownID'],
        ],
        [
            'label' => 'Example',
            'content' => 'http://localhost/autoupdate/web/index.php?r=Dintable%2Fdtab%2Fdoform&tab=mock_cars',
         // 'content' => 'http://www.example.com',
        ],
        [
            'label' => 'Dropdown',
            'items' => [
                 [
                     'label' => 'DropdownA',
                     'content' => 'DropdownA, Anim pariatur cliche...',
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
]);
?>

</div>