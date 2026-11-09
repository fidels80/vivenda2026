<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblGroup */

$this->title = 'Create Tbl Group';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
