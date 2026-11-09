<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property string|null $codice
 * @property string|null $descrizione
 * @property string|null $nota
 * @property int $id
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nota'], 'string'],
            [['codice'], 'string', 'max' => 25],
            [['descrizione'], 'string', 'max' => 100],
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
            'nota' => 'Nota',
            'id' => 'ID',
        ];
    }
}
