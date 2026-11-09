<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "xsubmenu".
 *
 * @property int $id
 * @property string|null $voce
 * @property string|null $azione
 * @property int|null $level
 * @property string|null $url
 * @property int $id_menu
 */
class Xsubmenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'xsubmenu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['azione', 'url','icona'], 'string'],
            [['level', 'id_menu'], 'integer'],
            [['id_menu'], 'required'],
            [['voce'], 'string', 'max' => 200],
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
            'id_menu' => 'Id Menu',
        ];
    }
}
