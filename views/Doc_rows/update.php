<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Doc_rows */

$this->title = 'Update Doc Rows: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Doc Rows', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="doc-rows-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
