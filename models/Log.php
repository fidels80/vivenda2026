<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int $userid
 * @property string $operazione
 * @property string|null $valore
 * @property string|null $old_valore
 * @property string $timeins
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'operazione'], 'required'],
            [['userid'], 'integer'],
            [['valore', 'old_valore'], 'string'],
            [['timeins'], 'safe'],
            [['operazione'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'operazione' => 'Operazione',
            'valore' => 'Valore',
            'old_valore' => 'Old Valore',
            'timeins' => 'Timeins',
        ];
    }
}
