<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cal".
 *
 * @property int $id
 * @property string|null $dadata
 * @property string|null $adata
 * @property string|null $elemento
 */
class Cal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dadata', 'adata'], 'safe'],
            [['elemento'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dadata' => 'Dadata',
            'adata' => 'Adata',
            'elemento' => 'Elemento',
        ];
    }
}
