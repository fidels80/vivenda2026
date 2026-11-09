<?php

namespace app\modules\autoupdate\models;

use Yii;

/**
 * This is the model class for table "rls_brd_shp".
 *
 * @property int $id
 * @property int $brand_id
 * @property int $shop_id
 */
class RlsBrdShp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rls_brd_shp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'shop_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'shop_id' => 'Shop ID',
        ];
    }
}
