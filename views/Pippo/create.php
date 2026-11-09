<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pippo */

$this->title = 'Create Pippo';
$this->params['breadcrumbs'][] = ['label' => 'Pippos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pippo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
