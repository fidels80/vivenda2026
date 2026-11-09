<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Xsubmenu */

$this->title = 'Create Xsubmenu';
$this->params['breadcrumbs'][] = ['label' => 'Xsubmenus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xsubmenu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
