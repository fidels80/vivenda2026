<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

//$this->title = $name;
//$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="error-page">
    <div class="error-content" style="margin-left: auto;">
        <h3><i class="fas fa-exclamation-triangle text-danger"></i>
         <?= Html::encode('In Costruzione') ?></h3>
       <p>
            <?= nl2br(Html::encode($message)) ?>
        </p>
        <p>
            La pagina che stai cercando verrà realizzata in base alle tue istruzioni
            nel frattempo puoi tornare a usare la 
            <?= Html::a(' dashboard', Yii::$app->homeUrl); ?>
        </p>
    </div>
</div>

