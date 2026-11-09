<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "xaction".
 *
 * @property int $id
 * @property string|null $Tipo
 */
class Xaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'xaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Tipo'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Tipo' => 'Tipo',
        ];
    }
}
