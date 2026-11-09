<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\models\User;
//use app\models\Tblshop;
use DOMDocument;
use Yii;
//use app\models\TblGroup;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;
use  yii\db\PdoValue;
use yii\web\UploadedFile;
use yii\base\DynamicModel;

/**
 * TblshopController implements the CRUD actions for Tblshop model.
 */
class RestController extends ActiveController
{
    use AccessDeniedTrait;

    public $modelClass = 'app\models\users';
    public $stat_hash = '$2y$13$6dpv6XRT1tRQu9RZFfnKvOYIoiOiS5.PHzP5qsQqp1s83LBu90d.6';

    /*  public function actionPath($id, $brand, $type, $ncassa = 0) {
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
     */
    public function actionGetactions($type)
    {

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

    public function actionValxml($xsd = null, $xml = null)
    {
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

    public function getuser()
    {
        $usrid = Yii::$app->user->Id;

        if ($usrid !== null) {
            $ris = (new \yii\db\Query())
                ->select(['level', 'cd_cli', 'moduli'])
                ->from('user')
                ->where(['id' => $usrid])
                ->one();
//->AsArray();
            $nmod = (str_replace('app\controllers', '', str_replace('Controller', '', __CLASS__)));
            $nmod = (str_replace('\\', '', $nmod));
//yii::error('---------nmod----');

            $nmod = strtoupper($nmod);
            yii::error($nmod);

            $mn = (new \yii\db\Query())
                ->select(['voce', 'url', 'Nmodulo'])
                ->from('xmenu')
                ->where(['upper(Nmodulo)' => strtoupper($nmod)])
                ->one();
        }

        $arrmod = unserialize($ris['moduli']);
        $go = 0;
        if ($ris['level'] != 100) {
            foreach ($arrmod as $value) {
                if (strtoupper($value) == strtoupper($mn['voce'])) {
                    $go = 1;
                }
            }
        } else {
            $go = 1;
        }
//var_dump($ris);
        if (Yii::$app->user->isGuest || $ris['level'] == null) {

            $messaggio =
                "<h1>Attenzione</h1>\n\n"
                . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";

            $this->denyAccess();

        }

        if ($go == 0) {

            $messaggio =
                "<h1>Attenzione</h1>\n\n"
                . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";

            $this->denyAccess();

        }

    }

    public function gethash($hash)
    {
//return false;
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'password_hash' => $hash,
            'rest' => 1,
        ]);

        return $user;

    }

    public function actionArcapostconferma($id, $hash)
    {
        if
        ($this->gethash($hash) == false) {
            return "K.O. utente non autorizzato!!!";

        } else {

            $query = yii::$app->db2
                ->createCommand()
                ->update('dotes', ['xconfermato' => 1], 'id_dotes=:id')
            // ->where(['id_dotes'=>$id])
                ->bindValue(':id', $id)
                ->execute();

            return 'OK';

        }

    }

    public function actionArcapostannulla($id, $hash)
    {
        if
        ($this->gethash($hash) == false) {
            return "K.O. utente non autorizzato!!!";

        } else {

            $query = yii::$app->db2
                ->createCommand()
                ->update('dotes', ['xannullato' => 1], 'id_dotes=:id')
            // ->where(['id_dotes'=>$id])
                ->bindValue(':id', $id)
                ->execute();

            return 'ok';

        }

    }
/*"insert into DmsDocument(content,entityTable,descrizione,filename,EntityId)
values
(convert(
VARBINARY(max) ,
:contenuto ,1),'DOTES',:descrizione,:filename,:EntityId)

"*/
    public function actionArcapostfile($hash, $content=null, $id, $fn)
    {
        if ($this->gethash($hash) == false) {
            return "K.O. utente non autorizzato!!!";
        } else {


//$content= $_POST['content'];
//die (print_r($_POST['content']));
/*$data = Yii::$app->request->post();
if (!isset($_POST['file'])){

die ("non sono riuscito a caricare il file");

}*/
//$data=file_get_contents("php://input");
//die (var_dump($data));
$model = new DynamicModel(['file' => null]);
$model->addRule('file', 'file',
 ['extensions' => $module->expansions, 'maxSize' => $module->maxSize]);
//= UploadedFile::getInstanceByName('image');

$model->file  = \yii\web\UploadedFile::getInstancesByName('file');
if (empty($model->file )) {
    die ('nessun file inviato');
    // handle error reporting somewhere else
}
else {
    
  //  $h = //'0x'.bin2hex((binary)
//pack("0x*",

//(binary) (file_get_contents($uploads->tempName));
//$h = //'0x'.bin2hex((binary)
//pack("0x*",

//(binary) (file_get_contents($uploads['tempName']));
//file_get_contents($uploads['tempName']);
    
    //  $model->file;


foreach($model->file as $value){
    //var_dump( $value->tempName);
$h = //'0x'.bin2hex((binary)
//pack("0x*",

(binary) (file_get_contents($value->tempName));
$nomefile=basename($value->name);
$content = '0x' . bin2hex($h);

}

//$f=$model->file ;
//return '0x'.bin2hex($h);



}



/*


   $path=Yii::getAlias('@webroot').'/uploads/';
                $file=str_replace(' ', '_',$fn);
                 $file2 = $path . $id.'_'.$fn;
                 //yii::warning
        //         var_dump($tmpfile['nome_file']);
                
if (!is_null($fn)) {
    $tmf=
                      fopen($file2, 'wb');
   fwrite($tmf, (
        '0x'.bin2hex($h) 
   ));
//file_put_contents(  $file2,  '0x'.bin2hex($h));


   // fprintf($content, "%c",0x1);
    //, 0x1);

    fclose($tmf);
}
*/

//fopen('x'.$file2, 'wb');

//file_put_contents('x'.$file2, base64_decode($content));







            $query = yii::$app->db2
                ->createCommand(
                    "insert into DmsDocument(
    content,
    entityTable,
    descrizione,
    filename,
    EntityId,
DocumentDate,
LinkedToFS,
filesize,
FilePath,
note,
ComputerName,
id_dmsclass1,
id_dmsclass2,
dmsclass3,EntityDescription,Cd_DmsType
)
values
( convert( VARBINARY(max) , :contenuto,1),
        'DOTES',:descrizione,:filename,
       :EntityId
       ,getdate(),0,
       :filesize,
            '\\web\upload\',
            'caricato da web',
            'YII',
            1,
            5,
            'PRV','PRV  2108     del 25-07-22','00'
            )

"

                )
                ->bindValue(':descrizione',$fn.  '  Caricato da portale web')
                ->bindValue(':filename', $fn)
                ->bindValue(':EntityId', intval($id))
                //,\PDO::PARAM_INT)
                ->bindValue(':filesize', strlen($content))
         ->bindValue(':contenuto','0x' . bin2hex($h)
);

                 $query->execute();

                  $query2=yii::$app->db2
                ->createCommand("
           update DmsDocument set content=convert(
            VARBINARY(max) ,
            :contenuto ,1) where EntityId=:id and EntityTable='DOTES'
           ", [':id' => $id, ':contenuto' => '0x'.bin2hex($h)
           //'0x' . bin2hex($h)
        ]);
         $query2->execute();

        //$command->execute();


            return $content; 
            //$query->getRawSql();

        }

    }

    public function actionArcagetfile($hash)
    {

    }

    public function actionArcagetdocs($hash)
    {

    }

    public function actionArcagetsc($hash)
    {

    }

    public function actionArcagetart($hash)
    {

    }

    public function actionArcagetcli($hash)
    {

    }

}

/*

$client = new Client();
$response = $client->createRequest()
->setMethod('post')
->setUrl('http://example.com/api/1.0/users')
->setData(['name' => 'John Doe', 'email' => 'johndoe@domain.com'])
->send();
if ($response->isOk) {
$newUserId = $response->data['id'];
}

 */
