<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Agenda */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Agendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="agenda-view">

 
    <h1><?= Html::encode($model->elemento.
    '  dal '.substr($model->dadata,0,-7) 
    .' al '.substr($model->adata,0,-7) ) ?></h1>

    <p>
        <?= Html::a('Aggiorna', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
      //      'id',
      'elemento',
          
      'dadata',
            'adata',
            'descrizione',
            'nota'
        ],
    ]) ?>

<?php 
echo '<table id="product-parcels" class="table table-condensed table-bordered">';
        echo '<thead>';
        echo '<tr>';
        //echo '<th>id_agenda</th>';
        echo '<th>descrizione</th>';
        echo '<th>Nota</th>';
        echo '<th>nome_file</th>';
        echo '<th>estensione</th>';
        echo '<th>Scarica</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        

 



    foreach ($model->filesall as $value) {
        echo '<tr>';
        //echo  '<td>';
        //echo $value['id_agenda'];
        //echo '</td>';
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
        echo  Html::a('scarica',['agenda/genfile','id' => $value['id'],'file'=>str_replace(' ', '_',$value['nome_file']) ]);
        echo '</td>';
        echo '</tr>';
       
     }
      echo '<tr id="product-new-parcel-block" style="display: none;">';
      echo '</tr>';
      echo '</tbody>';
      echo '</table>';

?>

</div>
