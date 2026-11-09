<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rlsbrdshp */

$this->title = 'Create Rlsbrdshp';
$this->params['breadcrumbs'][] = ['label' => 'Rlsbrdshps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rlsbrdshp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
