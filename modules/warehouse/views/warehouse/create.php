<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\WhStores */

$this->title = 'Create Wh Stores';
$this->params['breadcrumbs'][] = ['label' => 'Wh Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wh-stores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
