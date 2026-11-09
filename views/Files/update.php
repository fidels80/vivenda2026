<?php

use yii\helpers\Html;
use yii\web\UploadedFile;
 
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Files */

$this->title = 'Update Files: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="files-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

<?=   $form->field($model, 'file')->textInput(['readonly' => true,]) 
?>
 
<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
