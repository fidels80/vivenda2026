<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usr_grp".
 *
 * @property string $codice
 * @property string|null $descrizione
 */
class Usrgrp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usr_grp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codice'], 'required'],
            [['codice'], 'string', 'max' => 20],
            [['descrizione'], 'string', 'max' => 150],
            [['moduli','reports'],'string'],
            [['codice'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codice' => 'Codice',
            'descrizione' => 'Descrizione',
        ];
    }
}
