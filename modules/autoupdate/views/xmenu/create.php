<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Xmenu */

$this->title = 'Create Xmenu';
$this->params['breadcrumbs'][] = ['label' => 'Xmenus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xmenu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
