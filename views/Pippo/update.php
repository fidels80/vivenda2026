<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pippo */

$this->title = 'Update Pippo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pippos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pippo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
