<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "locazioni".
 *
 * @property string $id
 * @property string|null $descrizione
 * @property string|null $colore
 */
class Locazioni extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'locazioni';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'descrizione'], 'string', 'max' => 50],
            [['colore'], 'string', 'max' => 10],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descrizione' => 'Descrizione',
            'colore' => 'Colore',
        ];
    }
}
