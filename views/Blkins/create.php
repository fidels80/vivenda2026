<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Blkins */

$this->title = 'Create Blkins';
$this->params['breadcrumbs'][] = ['label' => 'Blkins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blkins-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
