<?php

namespace app\modules\presenze\controllers;

use yii\web\Controller;

/**
 * Default controller for the `Dintable` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actiondDoform($tab)
    {
        return $this->render('form',[ 'tab'=> $tab]);
    }
    


}
