<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Xaction */

$this->title = 'Create Xaction';
$this->params['breadcrumbs'][] = ['label' => 'Xactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xaction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
