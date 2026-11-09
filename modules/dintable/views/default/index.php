<div class="Dintable-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>

<?php 
 use yii\helpers\Html;
  
 if (Yii::$app->user->isGuest) {

 }else {
    echo Html::a('tabulars', ['/Dintable/tabs/tab' ]);
    echo '</br>';
    echo '</br>';
    echo '</br>';
    echo '</br>';
    echo '</br>';
    echo Yii::$app->controller->module->GetTab();; 

//echo GetTab();


 }

?>

