<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgendaFiles */

$this->title = 'Create Agenda Files';
$this->params['breadcrumbs'][] = ['label' => 'Agenda Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agenda-files-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
