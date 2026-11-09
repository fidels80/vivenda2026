<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Locazioni */

$this->title = 'Update Locazioni: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Locazionis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="locazioni-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
