<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string|null $nome
 * @property resource|null $file
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
            [['nome'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'file' => 'File',
        ];
    }
    public function upload() {
        if ($this->validate()) {
           $this->file->saveAs('../web/uploads/'.$this->id.'_'. str_replace(' ', '_',$this->file->baseName) . '.' .
              $this->file->extension);
           return true;
        } else {
           return false;
        }
     }
}
