<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_type".
 *
 * @property string $cd_doc
 * @property string $descrizione
 */
class DocType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cd_doc', 'descrizione'], 'required'],
            [['cd_doc'], 'string', 'max' => 3],
            [['descrizione'], 'string', 'max' => 50],
            [['cd_doc'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cd_doc' => 'Cd Doc',
            'descrizione' => 'Descrizione',
        ];
    }
}
