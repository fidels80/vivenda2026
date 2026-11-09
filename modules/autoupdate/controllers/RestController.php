<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\autoupdate\controllers;

use yii\rest\ActiveController;
use Yii;
use app\modules\autoupdate\models\Tblshop;
use app\modules\autoupdate\models\TblshopSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\autoupdate\models\TblGroup;
use app\modules\autoupdate\models\TblBrand;
use yii\helpers\Json;
use yii\web\Response;
use app\modules\autoupdate\models\Rlsbrdshp;
use DateTime;
use app\models\User;
use DOMDocument;

/**
 * TblshopController implements the CRUD actions for Tblshop model.
 */
class RestController extends ActiveController {

    public $modelClass = 'app\modules\autoupdate\models\Tblshop';

    public function actionPath($id, $brand, $type, $ncassa = 0) {
        //echo \Yii::$app->user->identity->getAuthKey(); 
        $model = tblshop::find()
                ->leftjoin('tbl_brand', 'tbl_brand.id = tbl_shop.brand_id')
                ->where(['tbl_shop.code' => $id])
                ->andwhere(['tbl_brand.code' => $brand])
                ->andwhere(['numcassa' => $ncassa])
                ->one();
        // return $model;

        if ($model['upd'] == 1) {
            return "<VUOTO>";
        }

        //return $model;
        if ($model['flag'] == 1) {

            if (isset($model['spec_path'])) {
                //  $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                // return $model['spec_path'];
                if ($type == 'j') {
                    \Yii::$app->response->format = Response::FORMAT_JSON;

                    return $model;
                } else {
                    return $model['spec_path'];
                }
            } else {
                return "<VUOTO>";
            }
        } else {
            $gmodel = TblGroup::find()
                    ->where(['id' => $model['brand_grp_id']])
                    ->one();
            //     return $gmodel;
            if ($gmodel['flag'] == 1) {

                if (isset($gmodel['grp_path'])) {
                    if ($type == 'j') {
                        \Yii::$app->response->format = Response::FORMAT_JSON;
                        return $gmodel;
                    } else {
                        return $gmodel['grp_path'];
                    }
                } else {
                    return "<VUOTO>";
                }
            } else {
                $bmodel = TblBrand::find()
                        ->where(['id' => $brand])
                        ->one();
                return $bmodel['defa_path'];
            }
        }
    }

    public function actionPrg($id, $brand, $version, $key = null) {

        if (isset($key)) {
            $k = user::find()
                    ->where(['auth_key' => $key])
                    ->one();
            if (isset($k) == false) {
                return 'accesso negato';
            }


            $model = tblshop::find()
                    ->leftjoin('tbl_brand', 'tbl_brand.id = tbl_shop.brand_id')
                    ->where(['tbl_shop.code' => $id])
                    ->andwhere(['tbl_brand.code' => $brand])
                    ->one();
            if (isset($model)) {
                $model->version = $version;
                $model->save();
                return 'ok';
            } else {
                return 'ko';
            }
        }
    }

    public function actionChkupd($id, $brand, $ncassa = 0) {
        $model = tblshop::find()
                ->leftjoin('tbl_brand', 'tbl_brand.id = tbl_shop.brand_id')
                ->where(['tbl_shop.code' => $id])
                ->andwhere(['tbl_brand.code' => $brand])
                ->andwhere(['numcassa' => $ncassa])
                ->one();
        //return $model;
        if (isset($model)) {
            if ($model->flag == null) {
                //   return "fla null";
                $model->flag = 0;
            }

            $model->upd = 1;

            $time = new \DateTime('NOW');
            // $time->format('m-d-Y H:i:s');
            $tmpd = $time->format('Y-m-d H:i:s');
            // $tmpd=$time->date;
            // return $model;
            $model->data_up = $tmpd;
            // return $model;
            // $model->save();
            $chk = $model->validate();
            if ($chk == false) {
                //return $model;
                return ($model->errors);
            }
            $model->save(false);

            return 'ok'; //$model;  
        } else {
            return 'ko';
        }
    }

    public function actionGetlic($id, $brand, $ncassa = 0) {
        $model = tblshop::find()
                ->leftjoin('tbl_brand', 'tbl_brand.id = tbl_shop.brand_id')
                ->where(['tbl_shop.code' => $id])
                ->andwhere(['tbl_brand.code' => $brand])
                ->andwhere(['numcassa' => $ncassa])
                ->one();
        if (isset($model)) {
            if ($model->licenza == 1) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function actionGetactions($type) {

        $controllerlist = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file == 'RestController.php') {
                    $controllerlist[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        $fulllist = [];
        foreach ($controllerlist as $controller):
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;
        if ($type == 'j') {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $fulllist;
        } else {
            return $fulllist;
        }
    }

    public function actionValxml($xsd = null, $xml = null) {
        // use DOMDocument; va messo nel top se si sposta l'azione su un altro controller
        libxml_use_internal_errors(true);
        libxml_clear_errors();
        if (isset($xsd) && isset($xml)) {
            $cxml = fopen($xml, "r");
            $cxsd = fopen($xsd, "r");
      /*      if ($cxml == false) {
                return "FILE  XML NON TROVATO";
            }
            if ($cxsd == false) {
                return "FILE  XSD NON TROVATO";
            }*/
        } else {
            $xsd = "/var/www/html/main/basic/xml/Schema_VFPR12.xsd";
            //../xml/Schema_DatiFattura_29052020.xsd";//sftp://root@www.anpira.it:8052/var/www/html/main/basic/xml/Schema_DatiFattura_29052020.xsd
            $xml = '/var/www/html/main/basic/xml/ft2.xml';
            // libxml_use_internal_errors(true);
            $test = fopen($xml, "r");
            if ($test) {
                $x = fread($test, filesize($xml));
                // return $x;   
            }
        }

        $rxml = new DOMDocument();
        $rxml->load($xml);
//echo $doc->saveXML();
//return ( $rxml->saveXML());


        if (!$rxml->schemaValidate($xsd)) {
            // print '<b>DOMDocument::schemaValidate() Generated Errors!</b>';
            return libxml_get_errors();
        } else {
            return 'ok';
        }
    }

}
