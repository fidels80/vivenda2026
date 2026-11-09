<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TblBrand */

$this->title = 'Create Tbl Brand';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-brand-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
