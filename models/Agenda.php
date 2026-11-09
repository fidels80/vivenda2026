<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "agenda".
 *
 * @property int $id
 * @property string|null $dadata
 * @property string|null $adata
 * @property string|null $elemento
 */
class Agenda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agenda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dadata', 'adata'], 'safe'],
            [['elemento'], 'string', 'max' => 50],
            [['descrizione'],'string', 'max' => 80],
            [['nota'],'string'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dadata' => 'Dadata',
            'adata' => 'Adata',
            'elemento' => 'Elemento',
        ];
    }
    public function getFilesall(){
        return $this->hasMany(AgendaFiles::className(),['id_agenda'=>'id']);
    }
}
