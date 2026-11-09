<?php
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\User $user */

//->createUrl(['user/resetp', 'token' => $user->password_reset_token]);

?>
Benvenuto  <?=$user->username?>,

la tua utenza è stata attivata accedi al portale per cominciare!! 
    
    <?php echo Url::base();
?>