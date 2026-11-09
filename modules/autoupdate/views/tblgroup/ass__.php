<?php
 use kartik\sortinput\SortableInput;
use yii\helpers\Html;
use app\models\TblBrand;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use app\models\tlbshop;
use kartik\sortable\Sortable;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$tliberi=tlbshop::find()
            ->select (['code as content','id as id'])
            ->where(['brand_id'=>$model->brand_id])
            ->andwhere(['brand_grp_id'=>0])
        ->asArray()
        ->all();
$nliberi=ArrayHelper::index($tliberi, 'id');
//$listiberi=ArrayHelper::map($nliberi, 'content','id');
 
/*'items' => [
1 => ['content' => 'Item # 1'],
2 => ['content' => 'Item # 2'],
3 => ['content' => 'Item # 3'],
4 => ['content' => 'Item # 4'],
5 => ['content' => 'Item # 5'],
],*/
$tass=tlbshop::find()
            ->select (['code as content','id'])
            ->where(['brand_id'=>$model->brand_id])
            ->andwhere(['brand_grp_id'=>$model->id])
        ->asArray()
        ->all();
 
$nass=ArrayHelper::index($tass, 'id');



$brd = TblBrand::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listbrd = ArrayHelper::map($brd, 'id', 'Name');
/* @var $this yii\web\View */
/* @var $model app\models\TblGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-group-form">
<?php $form = ActiveForm::begin(); ?>
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'code',
            'desk',
           ['label'=>'Azienda',
               'value'=>function ($data) {
        $tmp=TblBrand::find() ->where(['id'=>$data['brand_id']]) ->one();       
        return $tmp->desk;
                }],
          ['label'=>'Percorso',
              'value'=>function ($data) {
              return $data->grp_path;
              }]              
              
            
        ],
    ]) ?>

</div>
<?php /*echo Sortable::widget([
    'connected'=>true,
    'items'=>$nass
]);
echo Sortable::widget([
    'connected'=>true,
    'itemOptions'=>['class'=>'alert alert-warning'],
    'items'=>$nliberi
    /*[
        ['content'=>'To Item 1'],
        ['content'=>'To Item 2'],
        ['content'=>'To Item 3'],
        ['content'=>'To Item 4'],
    ]*/
/*]);
echo '<div class="clearfix"></div>';
*/

echo '<div class="row">';
echo '<div class="col-sm-6">';

echo SortableInput::widget([
'name'=>'natt',
'items' => $nass,
'hideInput' => false,
'sortableOptions' => [
'connected'=>true,
],
'options' => ['class'=>'form-control', 'readonly'=>true]
]);
echo '</div>';
echo '<div class="col-sm-6">';
echo SortableInput::widget([
'name'=>'nlib',
'items' => 
$nliberi,
'hideInput' => false,
'sortableOptions' => [
'itemOptions'=>['class'=>'alert alert-warning'],
'connected'=>true,
],
'options' => ['class'=>'form-control', 'readonly'=>true]
]);
echo '</div>';
echo '</div>';
 ?>
 

<?= Html::a('aggiorna gruppo', ['tblgroup/sync','id' =>$model->id,'nass'=>$nass,'lib'=>$nliberi], ['class'=>'btn btn-primary']) ?>
<?php  $url=Url::to(['tblgroup/sync','id' => $model->id,'nass'=>$nass,'lib'=>$nliberi]);
// Html::button('Modifica',['value'=>$url,'class' => 'btn btn-success','id'=>'salva']);?>
<?php $form = ActiveForm::end(); ?>
</div>