<?php

namespace app\modules\presenze\models;

use Yii;

/**
 * This is the model class for table "splitted_trans".
 *
 * @property int $id
 * @property int $type
 * @property string $data
 * @property string $ora
 * @property string $codicepersonale
 * @property int $sorgente
 * @property bool $direzione
 * @property string $x
 * @property int $esitocc
 * @property int $presenze_id
 */
class Splitted_trans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'splitted_trans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'sorgente', 'esitocc', 'presenze_id'], 'integer'],
            [['direzione'], 'boolean'],
            [['data', 'ora'], 'string', 'max' => 12],
            [['codicepersonale', 'x'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'data' => 'Data',
            'ora' => 'Ora',
            'codicepersonale' => 'Codicepersonale',
            'sorgente' => 'Sorgente',
            'direzione' => 'Direzione',
            'x' => 'X',
            'esitocc' => 'Esitocc',
            'presenze_id' => 'Presenze ID',
        ];
    }
}
