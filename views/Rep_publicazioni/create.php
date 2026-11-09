<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rep_publicazioni */

$this->title = 'Create Rep Publicazioni';
$this->params['breadcrumbs'][] = ['label' => 'Rep Publicazionis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rep-publicazioni-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
