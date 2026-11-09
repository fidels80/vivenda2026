<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rlsbrdshp */

$this->title = 'Update Rlsbrdshp: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rlsbrdshps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rlsbrdshp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
