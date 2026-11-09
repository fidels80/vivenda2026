<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Anacli */

$this->title = 'Update Anacli: ' . $model->cd_cli;
$this->params['breadcrumbs'][] = ['label' => 'Anaclis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cd_cli, 'url' => ['view', 'id' => $model->cd_cli]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="anacli-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
