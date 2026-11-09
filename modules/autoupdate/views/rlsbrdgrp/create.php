<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rlsbrdgrp */

$this->title = 'Create Rlsbrdgrp';
$this->params['breadcrumbs'][] = ['label' => 'Rlsbrdgrps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rlsbrdgrp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
