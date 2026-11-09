<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "xmenu".
 *
 * @property int $id
 * @property string $voce
 * @property string|null $azione
 * @property int $level
 * @property string $url
 */
class Xmenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'xmenu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'level'], 'integer'],
            [['voce', 'azione','icona'], 'string', 'max' => 200],
            [['url'], 'string', 'max' => 250],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'voce' => 'Voce',
            'azione' => 'Azione',
            'level' => 'Level',
            'url' => 'Url',
        ];
    }
}
