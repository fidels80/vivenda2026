<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blk_ins".
 *
 * @property int $id
 * @property string|null $CC_CLIENTE
 * @property string|null $agente
 * @property string|null $Tipo_evento
 * @property int|null $importato
 * @property string|null $Codice_progetto
 * @property string|null $descrizione
 * @property string|null $note
 */
class BlkIns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blk_ins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CC_CLIENTE', 'agente', 'Tipo_evento', 'note'], 'string'],
            [['importato'], 'integer'],
            [['Codice_progetto'], 'string', 'max' => 100],
            [['descrizione'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'CC_CLIENTE' => 'Cc Cliente',
            'agente' => 'Agente',
            'Tipo_evento' => 'Tipo Evento',
            'importato' => 'Importato',
            'Codice_progetto' => 'Codice Progetto',
            'descrizione' => 'Descrizione',
            'note' => 'Note',
        ];
    }
}
