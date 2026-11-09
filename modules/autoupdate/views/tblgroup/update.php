<?php
//namespace app\modules\autoupdate\models;
use yii\web\JsExpression;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TblBrand;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\modules\autoupdate\models\Tblshop;
use yii\grid\GridView;
use kartik\sortinput\SortableInput;
use yii\helpers\Url;

$tliberi = tblshop::find()
        ->select(['code as content', 'id as id'])
        ->where(['brand_id' => $model->brand_id])
        ->andwhere(['brand_grp_id' => 0])
        ->asArray()
        ->all();
$tliberi2 = tblshop::find()
        ->select(['code as name', 'id as id'])
        ->where(['brand_id' => $model->brand_id])
        ->andwhere(['brand_grp_id' => 0])
        ->asArray()
        ->all();

$sliberi = ArrayHelper::map($tliberi2, 'id', 'name');
$nliberi = ArrayHelper::index($tliberi, 'id');
$tass = tblshop::find()
        ->select(['code as content', 'id'])
        ->where(['brand_id' => $model->brand_id])
        ->andwhere(['brand_grp_id' => $model->id])
        ->asArray()
        ->all();

$nass = ArrayHelper::index($tass, 'id');


$brd = TblBrand::find()
        ->select(['id as id', 'desk as  Name'])
        ->asArray()
        ->all();
$listbrd = ArrayHelper::map($brd, 'id', 'Name');

$shp = new ActiveDataProvider([
    'query' =>
            Tblshop::find()
            ->select(['id', 'code', 'desk', 'flag', 'upd', 'data_up'])
            ->where(['brand_id' => $model['brand_id']])
            ->andwhere(['brand_grp_id' => $model['id']])
        //   ->asarray()
        ]);
/* @var $this yii\web\View */
/* @var $model app\models\TblGroup */

$this->title = 'Update Tbl Group: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tbl-group-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        <?= $form->field($model, 'desk')->textInput(['maxlength' => true]) ?>

        <?=
        $form->field($model, 'brand_id')->widget(Select2::classname(), ['name' => 'brand', 'data' => $listbrd,
            'options' => ['placeholder' => 'Seleziona azienda ...',],
            'pluginOptions' => [
                'allowClear' => true, 'readonly' => true
            ],
        ])->label('azienda');
        ?>

<?= $form->field($model, 'grp_path')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'flag')->checkbox(['label' => 'Attivo']) ?>


        <?php
        // echo '<div class="row">';
        echo '<div class="col-xs-6" style="height: 400px; overflow: auto">';
        echo $form->field($model, 'lista')->widget(SortableInput::classname(), [
            'items' => $nass,
            'hideInput' => true,
            'sortableOptions' => [
                'connected' => true,
                'type' => 'grid',
            ],
            'options' => ['class' => 'form-control', 'readonly' => false]
        ])->label('Negozi Assegnati');

        echo '<table><tr>';
        $ajaxJs = <<< JS
function(data) {
    doc = new DOMParser().parseFromString('<li class="alert alert-warning" data-key="' + (data.params.data.id ) +
      '"role="option" aria-grabbed="false" draggable="true">' + data.params.data.text + '</li>', "text/html").body.firstChild;
        console.log(data.params.data);
   $('li:contains('+data.params.data.text+')').remove();     
   document.getElementById('tblgroup-lista').value=document.getElementById('tblgroup-lista').value+','+data.params.data.id
        document.querySelector('.sortable').appendChild(doc);
         a = document.getElementById('tblgroup-lista').value;
          l = document.getElementById('tblgroup-lista2').value;
          lib=     l.split(',');
        $("#tblgroup-lista2-sortable").find(doc).remove();
         console.log(doc);
for( var i = 0; i < lib.length; i++){ 
    if ( lib[i] === data.params.data.id) { lib.splice(i, 1); i--; }
        }
        lib2=lib.join(',');
        document.getElementById('tblgroup-lista2').value=lib2;
c=document.getElementById('tblgroup-lista2-sortable');
console.log(c);
       // c.removeChild(c.childNodes[data.params.data.text]);

   }
JS;



        echo Select2::widget([
            'name' => 'negoziliberi',
            'data' => $sliberi,
            'initValueText' => 'cerca negozio da assegnare ...',
            'options' => ['placeholder' => 'cerco negozio ...'],
            'pluginEvents' => [
                "select2:select" => new JsExpression($ajaxJs),
            ],
        ]);


        echo '</tr>';
        echo '<tr>';
      
        echo '</tr>';

        echo '</table>';
        echo '</div>';
        echo '<div class="col-xs-6" style="height: 400px; overflow: auto" >';
        echo $form->field($model, 'lista2')->widget(SortableInput::classname(), [
            'items' =>
            $nliberi,
            'hideInput' => true,
            'sortableOptions' => [
                'itemOptions' => ['class' => 'alert alert-warning'],
                'type' => 'grid',
                'connected' => true,
            ],
            'options' => ['class' => 'form-control', 'readonly' => true]
        ])->label('Negozi Liberi');

        echo '</div>';
        echo '</div>';
        echo '<table width=100% ><tr heigth="15">Tasti Funzione Rapida</tr><tr><td width=50%>';
        echo Html::button('Azzera Negozi Assegnati!', ArrayHelper::merge(['onclick' => 'azzera_li()'], ['id' => 'azzera']));
        echo '</td><Td>';
          echo Html::button('Assegna tutti i negozi', ArrayHelper::merge(['onclick' => 'all_in()'], ['id' => 'allin']));
        
        echo '</td></tr></table>';
        ?>

        <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>



        <?=
        GridView::widget([
            'dataProvider' => $shp,
            //'filterModel' => $searchModel,
            'columns' => [
                'code',
                ['attribute' => 'desk',
                    'label' => 'Descrizione'],
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
    </div>


    <script type="text/javascript">
        //the dropdown list id; This doesn't have to be a dropdown it can be any field type.
        function azzera_li()
        {

            list = document.getElementById("tblgroup-lista-sortable");
            list2 = document.getElementById("tblgroup-lista2-sortable");
            console.log(list.querySelectorAll('li'));
    // As long as <ul> has a child node, remove it
            while (list.hasChildNodes()) {
                tmpi = list.firstChild;
                cln = tmpi.cloneNode(true);
                list2.appendChild(cln);
                list.removeChild(list.firstChild);
            }
        document.getElementById("tblgroup-lista2").value=document.getElementById("tblgroup-lista2").value
                           +','+document.getElementById("tblgroup-lista").value;    
        document.getElementById("tblgroup-lista").value="";
        }
        ;
        function all_in()
        {
            //console.log(document.querySelector('.sortable'));
            list = document.getElementById("tblgroup-lista2-sortable");
            list2 = document.getElementById("tblgroup-lista-sortable");

    // As long as <ul> has a child node, remove it
            while (list.hasChildNodes()) {
                //console.log(list.firstChild.attributes);
                tmpi = list.firstChild;
                cln = tmpi.cloneNode(true);
                list2.appendChild(cln);
                list.removeChild(list.firstChild);
            }
                   document.getElementById("tblgroup-lista").value=document.getElementById("tblgroup-lista").value
                           +','+document.getElementById("tblgroup-lista2").value;
                 document.getElementById("tblgroup-lista2").value="";
    }
        ;
    </script>