<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Whprop */

$this->title = 'Create Whprop';
$this->params['breadcrumbs'][] = ['label' => 'Whprops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="whprop-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
