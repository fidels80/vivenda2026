<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
 
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $model app\models\TblBrand */
/* @var $form yii\widgets\ActiveForm */
use app\modules\autoupdate\models\TblGroup;
use app\modules\autoupdate\models\TblshopSearch;
use app\modules\autoupdate\models\Tblshop;
//$searchModel= new TblshopSearch();
/*$shp= 
        new ActiveDataProvider([
      'query' => 
        Tblshop::find()
        ->select(['id','code','desk','flag','upd','data_up','brand_grp_id'])
        ->where(['brand_id'=>$model['id']])
         
     //   ->asarray()
        ]);
 *
*/
$shp2=new ActiveDataProvider([
      'query' => 
        Tblshop::find()
        ->select(['id','code','desk','flag','upd','data_up','brand_grp_id'])
        ->where(['brand_id'=> $model['id']
                ])
         
     //   ->asarray()
        ]);
yii::warning($shp2);
?>
<?php  Pjax::begin(); ?>
<div class="tbl-brand-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'desk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'defa_path')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php //echo Url::to(['@app']);  //var_dump($shp);?>

<?php /* non fa il rendeer ajax boh.... 
 * $this->renderajax('@app/modules/autoupdate/views/tblshop/index', [
              'searchModel' => new TblshopSearch(),
               'dataProvider' => $shp,
            ]) */?>

 <?=
        GridView::widget([
            'dataProvider' => $shp,
            //'filterModel' => $searchModel,
            //'id','code','desk','flag','upd','data_up','brand_grp_id'
            'columns' => [
                'code',
                ['attribute' => 'desk',
                    'label' => 'Descrizione',
                     'enableSorting' => True],
                ['attribute' => 'flag',
                    'label' => 'Aggiornamento_specifico_PV'],
                ['attribute' => 'upd',
                    'label' => 'Aggiornamento_scaricato'],
                ['attribute' => 'data_up',
                    'label' => 'Data Download aggiornamento'],
                [
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a('modifica', ['/autoupdate/tblshop/update', 'id' => $data['id']]);
                    }
                ]
            ],
        ]);
        ?>


<?php  Pjax::end(); ?>