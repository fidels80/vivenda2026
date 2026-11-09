<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Whstores */

$this->title = 'Create Whstores';
$this->params['breadcrumbs'][] = ['label' => 'Whstores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="whstores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
