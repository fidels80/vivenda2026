<?php

namespace app\modules\autoupdate\models;

use Yii;

/**
 * This is the model class for table "rls_brd_grp".
 *
 * @property int $id
 * @property int $brand_id
 * @property int $group_id
 */
class Rlsbrdgrp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rls_brd_grp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'group_id'], 'integer'],
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
            'group_id' => 'Group ID',
        ];
    }
}
