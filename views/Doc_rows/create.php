<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Doc_rows */

$this->title = 'Create Doc Rows';
$this->params['breadcrumbs'][] = ['label' => 'Doc Rows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-rows-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
