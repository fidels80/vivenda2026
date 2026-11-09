<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Elemail */

$this->title = Yii::t('app', 'Create Elemail');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Elemails'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elemail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
