<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usrgrp */

$this->title = 'Create Usrgrp';
$this->params['breadcrumbs'][] = ['label' => 'Usrgrps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usrgrp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
