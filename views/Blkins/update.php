<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Blkins */

$this->title = 'Update Blkins: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Blkins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="blkins-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
