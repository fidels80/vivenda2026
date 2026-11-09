<?php

namespace app\modules\presenze\models;

use Yii;

/**
 * This is the model class for table "presenze".
 *
 * @property int $id
 * @property string $tran
 * @property string $idterm
 * @property string $datarec
 */
class presenze extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'presenze';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datarec'], 'safe'],
            [['tran', 'idterm'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tran' => 'Tran',
            'idterm' => 'Idterm',
            'datarec' => 'Datarec',
        ];
    }
}
