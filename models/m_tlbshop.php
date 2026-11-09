<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tlb_shop".
 *
 * @property int $id
 * @property string $code
 * @property string $desk
 * @property int $brand_id
 * @property int $spec_path
 * @property int $brand_grp_id
 */
class tlbshop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_shop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'brand_grp_id'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['desk','spec_path'], 'string', 'max' => 200],
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
            'brand_id' => 'Brand ID',
            'spec_path' => 'Spec Path',
            'brand_grp_id' => 'Brand Grp ID',
        ];
    }
}
