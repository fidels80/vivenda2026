<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\presenze\controllers;

use yii\rest\ActiveController;
use Yii;
use app\modules\presenze\models\presenze;
use app\modules\presenze\models\presenzeSearch;
use app\modules\presenze\models\Splitted_trans;
use app\modules\presenze\models\Splitted_transSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
 
use yii\helpers\Json;
use yii\web\Response;
 
use DateTime;
use app\models\User;
use DOMDocument;

/**
 * TblshopController implements the CRUD actions for Tblshop model.
 */
class RestController extends ActiveController {

    public $modelClass = 'app\modules\presenze\models\presenze';

    public function actionGreet(){
        return 'ciao';
    }
    public function actionHeartbeat(){
        echo 'cmd=CONSIDLE';
       
    }

    public function actionBatch($tran,$idterm){
        $model = new presenze();
        $model->setAttribute('tran', $tran);
        $model->setAttribute('idterm', $idterm);
        if ( $model->save()) {
            echo 'ack=1';
        } else {
            return ' ack=0';
        }
    }


public function actionOnline($tran,$idterm){
    $model = new presenze();
    $model->setAttribute('tran', $tran);
    $model->setAttribute('idterm', $idterm);
    $pieces = explode(",", $tran);
//CustomRecord="3,YYYY-MM-DD,hh:mm:ss,CCCCCCCCCC,S,V,XXXXXX,ee"


    if ( $model->save()) {
        $m2= new  Splitted_trans();
        $newid=$model->id;
        $m2->setAttribute('presenze_id', $newid);
        $m2->setAttribute('type', $pieces[0]);
        $m2->setAttribute('data', $pieces[1]);
        $m2->setAttribute('ora', $pieces[2]);
        $m2->setAttribute('codicepersonale', $pieces[3]);
        $m2->setAttribute('sorgente', $pieces[4]);
        $m2->setAttribute('direzione', $pieces[5]);
        $m2->setAttribute('x', $pieces[6]);
        $m2->setAttribute('esitocc', $pieces[7]);
        //var_dump($pieces);
        $m2->save();
        //echo $newid;
        if( $pieces[5]==0){
        echo "screen=\f Benvenuto|Fantozzi". PHP_EOL."beep=100 " ;//da il suono ok
        }else{
            echo "screen=\f Arrivederla |Fantozzi". PHP_EOL."beep=99 ";//da il suono non ok

        }


    } else {
        return ' non salvato';
    }

  


}

    /**
     * @return string
     */
    public function actionBarba()
    {
        return 'ciao barba';
    }




}
