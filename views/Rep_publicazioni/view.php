<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rep_publicazioni */

$this->title = $model->Id_DORig;
$this->params['breadcrumbs'][] = ['label' => 'Rep Publicazionis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rep-publicazioni-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Id_DORig], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Id_DORig], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cd_cf',
            'cd_Art',
            'descrizione',
            'datacons',
            'Cd_DOSottoCommessa',
            'Cd_DO',
            'PrezzoUnitarioScontatoV',
            'Qta',
            'PrezzoTotaleE',
            'Cd_ARMarca',
            'Id_DORig',
        ],
    ]) ?>

</div>
