<?php

namespace app\modules\autoupdate\models;

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
class Tblshop extends \yii\db\ActiveRecord
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
            [['brand_id',  'brand_grp_id','numcassa'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['data_up'],'safe'],
            [['desk','spec_path','version'], 'string', 'max' => 200],
            [['flag','upd','licenza'],'boolean']
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
            'version'=>'versione',
            'flag'=>'flag',
            'data_up'=>'data_up',
            'upd'=>'upd',
            'numcassa'=>'Numcassa',
            'licenza'=>'licenza attiva'
        ];
    }
}
