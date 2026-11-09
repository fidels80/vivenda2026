<?php

//namespace app\models;
namespace app\modules\warehouse\models;
use Yii;

/**
 * This is the model class for table "wh_stores".
 *
 * @property int $id
 * @property string $code
 * @property string|null $desk
 * @property string|null $address
 * @property int|null $city
 * @property int|null $zone
 * @property int|null $nation
 */
class Whstores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wh_stores';
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
            [['city', 'zone', 'nation'], 'integer'],
            [['code'], 'string', 'max' => 50],
            [['desk', 'address'], 'string', 'max' => 500],
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
            'address' => 'Address',
            'city' => 'City',
            'zone' => 'Zone',
            'nation' => 'Nation',
        ];
    }
}
