<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TlbShop */

$this->title = 'Create Tlb Shop';
$this->params['breadcrumbs'][] = ['label' => 'Tlb Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tlb-shop-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
