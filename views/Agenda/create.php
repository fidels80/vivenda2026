<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Agenda */

$this->title = 'Create Agenda';
$this->params['breadcrumbs'][] = ['label' => 'Agendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agenda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
