<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_rows".
 *
 * @property string $id
 * @property string $doc_head_id
 * @property string|null $cd_art
 * @property string|null $descrizione
 * @property string|null $um
 * @property float|null $qta
 * @property float|null $prezzo
 * @property string|null $sconto
 * @property string|null $note
 */
class Doc_rows extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_rows';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'doc_head_id', 'note'], 'string'],
            [['doc_head_id'], 'required'],
            [['qta', 'prezzo'], 'number'],
            [['cd_art'], 'string', 'max' => 50],
            [['cd_doc'], 'string', 'max' => 3],
            [['numdoc', 'cd_cli', 'nrgazzetta','nrinserzione'], 'string', 'max' => 10],
            [['data','datacons'], 'safe'],
            [['descrizione'], 'string', 'max' => 200],
            [['um'], 'string', 'max' => 3],
            [['sconto'], 'string', 'max' => 10],
            [['id'], 'unique'],
            [['f_row','nriga'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doc_head_id' => 'Doc Head ID',
            'cd_art' => 'Cd Art',
            'descrizione' => 'Descrizione',
            'um' => 'Um',
            'qta' => 'Qta',
            'prezzo' => 'Prezzo',
            'sconto' => 'Sconto',
            'note' => 'Note',
        ];
    }
    public function gethaed(){

        return $this->hasOne(doc_head::className(),['id'=>'doc_head_id']);

    }
}
