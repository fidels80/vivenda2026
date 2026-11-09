<?php

namespace app\controllers;

use Yii;

/**
 * Trait condiviso per il comportamento di accesso negato.
 * Se l'utente non e' loggato reindirizza alla login,
 * altrimenti reindirizza alla home (index).
 */
trait AccessDeniedTrait
{
    protected function denyAccess()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->getResponse()->redirect(['site/login'])->send();
        } else {
            Yii::$app->getResponse()->redirect(['site/index'])->send();
        }
        Yii::$app->end();
    }
}
