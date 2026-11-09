<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\presenze\models\Splitted_trans */

$this->title = 'Create Splitted Trans';
$this->params['breadcrumbs'][] = ['label' => 'Splitted Trans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="splitted-trans-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
