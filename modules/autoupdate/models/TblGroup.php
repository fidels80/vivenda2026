<?php

namespace app\modules\autoupdate\models;

use Yii;

/**
 * This is the model class for table "tbl_group".
 *
 * @property int $id
 * @property string $code
 * @property string $desk
 * @property int $brand_id
 * @property string|null $grp_path
 */

class TblGroup extends \yii\db\ActiveRecord
{

//public $lista=null;
//public $lista2=null;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'desk', 'brand_id'], 'required'],
            [['brand_id','flag',], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['desk'], 'string', 'max' => 200],
            [['grp_path'],'string', 'max' => 200],
            [['lista'],'string', 'max' => 5000],
            [['lista2'], 'string', 'max' => 5000],
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
            'grp_path' => 'Grp Path',
            'lista'=>'lista',
            'lista2'=>'lista2'
        ];
    }
}
