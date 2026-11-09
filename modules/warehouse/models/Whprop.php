<?php

namespace app\modules\warehouse\models;


use Yii;

/**
 * This is the model class for table "wh_prop".
 *
 * @property int $id
 * @property int|null $code
 * @property string $desk
 * @property int $father
 */
class Whprop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wh_prop';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('wh');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['father'], 'integer'],
            [['desk'], 'string', 'max' => 50],
            [['code'],'string', 'max' => 10],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'desk' => 'Desk',
            'father' => 'Father',
        ];
    }
}
