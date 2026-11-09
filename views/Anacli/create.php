<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Anacli */

$this->title = 'Create Anacli';
$this->params['breadcrumbs'][] = ['label' => 'Anaclis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anacli-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
