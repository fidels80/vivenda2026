<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mail".
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string|null $Soggetto
 * @property string|null $Corpo
 * @property string|null $allegati
 */
class Elemail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'email'], 'required'],
            [['nome', 'email', 'Soggetto', 'Corpo', 'allegati'], 'string'],
            [['data']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'email' => 'Email',
            'Soggetto' => 'Soggetto',
            'Corpo' => 'Corpo',
            'allegati' => 'Allegati',
            'data'=>'Data'
        ];
    }
}
