<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rep_publicazioni */

$this->title = 'Update Rep Publicazioni: ' . $model->Id_DORig;
$this->params['breadcrumbs'][] = ['label' => 'Rep Publicazionis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Id_DORig, 'url' => ['view', 'id' => $model->Id_DORig]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rep-publicazioni-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
