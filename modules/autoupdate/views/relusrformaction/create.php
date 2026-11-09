<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Relusrformaction */

$this->title = 'Create Relusrformaction';
$this->params['breadcrumbs'][] = ['label' => 'Relusrformactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relusrformaction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
