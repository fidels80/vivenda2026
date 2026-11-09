<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Agenda */
\yii\web\YiiAsset::register($this);
$this->title = 'Update Agenda: ' . $model->Agenda->id;
$this->params['breadcrumbs'][] = ['label' => 'Agendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Agenda->id,
 'url' => ['view', 'id' => $model->Agenda->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="agenda-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
