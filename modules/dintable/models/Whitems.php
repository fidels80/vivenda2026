<?php

namespace app\modules\dintable\models;

use Yii;

/**
 * This is the model class for table "wh_items".
 *
 * @property int $id
 * @property string $code
 * @property string $desk
 * @property string $prop
 */
class Whitems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wh_items';
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
            [['prop'], 'required'],
            [['prop'], 'string'],
            [['code'], 'string', 'max' => 50],
            [['desk'], 'string', 'max' => 500],
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
            'prop' => 'Prop',
        ];
    }
}
