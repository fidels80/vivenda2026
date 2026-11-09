<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_usr_form_action".
 *
 * @property int $id
 * @property int $id_user
 * @property string $form
 * @property bool $read
 * @property bool $write
 * @property bool $delete
 * @property bool $access
 */
class Relusrformaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rel_usr_form_action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user','level'], 'integer'],
            [['read', 'write', 'delete', 'access'], 'boolean'],
            [['form','azione'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'form' => 'Form',
            'read' => 'Read',
            'write' => 'Write',
            'delete' => 'Delete',
            'access' => 'Access',
            'level'=>'Livello'
        ];
    }
}
