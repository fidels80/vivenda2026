<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\presenze\models\Splitted_trans */

$this->title = 'Update Splitted Trans: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Splitted Trans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="splitted-trans-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
