<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;
    public $files;
  
    
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
            ['files','file' ,'maxFiles' => 10],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Codice Di Verifica',
            'subject'=>'Oggetto',
            'body'=>'Richiesta',
            'name'=>'Nome'
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email,$atcs,$atc2)
    {

        //die(print_r($this));
        if ($this->validate()) {
     $usrid = Yii::$app->user->Id;

if ($usrid !== null) {
    $ris = (new \yii\db\Query())
        ->select(['email', 'cd_cli'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();
//->AsArray();

}
$cc = (new \yii\db\Query())
    ->select(['ccemail'])
    ->from('ana_cli')
    ->where(['cd_cli' => $ris['cd_cli']])
    ->one();
$rcc = isset($cc['ccemail']) ? explode(';',$cc['ccemail']) : '';
//var_dump($

 //   'supportEmail'=>//'redazione@vivenda.it',


//die (var_dump($ris['email']));
            $message=Yii::$app->mailer->compose()
                //->setTo(Yii::$app->params['senderEmail'])
                ->setto($ris['email'])
                ->setFrom(yii::$app->params['supportEmail'])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body);
$path = Yii::getAlias('@webroot') . '/uploads/mail2/';
foreach ($atc2 as $file) {
    $filename = $path. $file->baseName . '.' . $file->extension; # i'd suggest adding an absolute path here, not a relative.
    $file->saveAs($filename);
    $message->attach($filename);
}
$rcc = isset($cc['ccemail']) ? $message->setCC(explode(';',$cc['ccemail'])) : '';

                 $message->send();






   $message2=Yii::$app->mailer->compose()
    ->setTo(yii::$app->params['adminEmail'])
    ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
    ->setReplyTo([$this->email => $this->name])
    ->setSubject($this->subject.' Inviato da '. $ris['email'])
    ->setTextBody($this->body);
   //  ->attach($this->files);

foreach ($atc2 as $file) {
    $filename = $path . $file->baseName . '.' . $file->extension; # i'd suggest adding an absolute path here, not a relative.
    $file->saveAs($filename);
    $message2->attach($filename);
}


   $message2 ->send();

           
//die(print_r($message));

foreach ($atc2 as $file) {
    $filename = $path . $file->baseName . '.' . $file->extension; # i'd suggest adding an absolute path here, not a relative.

    unlink($filename);
}
            return true;
        }
         die('non validato');

        return false;
    }
}
