<?php

namespace app\modules\autoupdate\models;


use Yii;

/**
 * This is the model class for table "tbl_brand".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $desk
 * @property string|null $defa_path
 */
class TblBrand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'string', 'max' => 10],
            [['desk', 'defa_path'], 'string', 'max' => 200],
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
            'defa_path' => 'Defa Path',
        ];
    }
}
