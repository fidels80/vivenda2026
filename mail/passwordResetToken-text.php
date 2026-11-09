<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

$resetLink = Yii::$app->urlManager
->createAbsoluteUrl(['user/resetp', 'token' => $user->password_reset_token]);
//->createUrl(['user/resetp', 'token' => $user->password_reset_token]);

?>
Hello <?=$user->username?>,

  Clicca sul link per andare a reimpostare la password :

<?=$resetLink?>