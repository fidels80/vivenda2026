<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "agenda_files".
 *
 * @property int $id
 * @property int|null $id_agenda
 * @property string|null $descrizione
 * @property string|null $nota
 * @property resource|null $f_content
 * @property string $nome_file
 * @property string $estenzione
 * @property string|null $uplfile
 * @property resource|null $file
 */
class AgendaFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agenda_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_agenda'], 'integer'],
            [['nota'],'string'],
            [[ 'f_content', 'nome_file', 'uplfile', 'file'], 'string'],
            [['nome_file', 'estenzione'], 'required'],
            [['descrizione'], 'string', 'max' => 200],
            [['estenzione'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_agenda' => 'Id Agenda',
            'descrizione' => 'Descrizione',
            'nota' => 'Nota',
            'f_content' => 'F Content',
            'nome_file' => 'Nome File',
            'estenzione' => 'Estenzione',
            'uplfile' => 'Uplfile',
            'file' => 'File',
        ];
    }
    public function getAgenda(){

        return $this->hasOne(Agenda::className(),['id'=>'id_agenda']);

    }
    public function upload() {
        if ( 
           $this->file->saveAs('../web/uploads/'. 
           str_replace(' ', '_',$this->file->baseName) . '.' .
              $this->file->extension)){
          // echo 'datt';
              return true;
        } else {
            //echo 'no';
           return false;
        }
     }
}
