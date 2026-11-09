<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\anacli;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $piva;
 

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User',
             'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
 
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Utente già'],

            ['password', 'required'],
            ['password', 'string', 'min' => 8],
            ['piva', 'required'],
            ['piva', 'string', 'min' => 8 ,'max'=>13],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->piva=$this->piva;
        
       /* 
        $cli= anacli::find()
        ->Select(['cd_cli'])
        ->where (['PartitaIva'=>$this->piva])
        ->AsArray()
        ->One();
        yii::warning($cli);
        if (empty($cli)==false){
        $user->cd_cli= $cli['cd_cli'];
       }
        
        */
        
        
        
        try {
            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'welcome-html',
                     'text' => 'welcome-text'],
                    ['user' => $user]
                )
                ->setFrom([Yii::$app->params['supportEmail'] =>  'Vivenda DASHBOARD'])
                ->setTo($this->email)
                ->setSubject('Benvenuto nel portale ' .'Vivenda DASHBOARD')
                ->send();
        } catch (\Exception $e) {
            Yii::error('Invio email fallito (Signup): ' . $e->getMessage(), __METHOD__);
            Yii::$app->session->setFlash('mail_failed',
                'La registrazione è stata salvata, ma non è stato possibile inviare l\'email di benvenuto.');
        }

        
        
        
        
        
        
        
        
        
        //var_dump($cli);
        
        
        return  $user->save() ? $user : null;
    }
}
