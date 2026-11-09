<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Allfiles */

$this->title = 'Carica File';
$this->params['breadcrumbs'][] = ['label' => 'Allfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allfiles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
