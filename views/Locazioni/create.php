<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Locazioni */

$this->title = 'Create Locazioni';
$this->params['breadcrumbs'][] = ['label' => 'Locazionis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locazioni-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
