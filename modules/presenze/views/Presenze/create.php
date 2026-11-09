<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\presenze\models\Presenze */

$this->title = 'Create Presenze';
$this->params['breadcrumbs'][] = ['label' => 'Presenzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presenze-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
