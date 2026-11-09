<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Doc_head */

$this->title = 'Create Doc Head';
$this->params['breadcrumbs'][] = ['label' => 'Doc Heads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-head-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
