<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Doc_head */

$this->title = 'Update Doc Head: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Doc Heads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="doc-head-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
