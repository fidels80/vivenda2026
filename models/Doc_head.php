<?php

namespace app\models;
use \yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "doc_head".
 *
 * @property string $id
 * @property string $cd_doc
 * @property string $data
 * @property string $numdoc
 * @property string $cd_cli
 * @property string|null $cd_pg
 * @property string|null $sconto
 * @property string|null $note
 */
class Doc_head extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_head';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'note','rifiutato_nota','xnota'], 'string'],
            [['cd_doc', 'data', 'numdoc', 'cd_cli'], 'required'],
            [['data'], 'safe'],
            [['confermato','rifiutato'], 'integer'], 
            [['cd_doc','dest'], 'string', 'max' => 3],
            [['numdoc', 'cd_cli', 'cd_pg', 'sconto','altcli'], 'string', 'max' => 10],
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
            'cd_doc' => 'Cd Doc',
            'data' => 'Data',
            'numdoc' => 'Numdoc',
            'cd_cli' => 'Cd Cli',
            'cd_pg' => 'Cd Pg',
            'sconto' => 'Sconto',
            'note' => 'Note',
            'dest'=>'Destinazione',
            'xnota'=>'Nota da Dashboard'
        ];
    }
    public function getRowsall(){
        return $this->hasMany(Doc_rows::className(),
        [//'xid_testa'=>'xid_testa'
        //,
        'doc_head_id'=>'id'
        ])->
         orderBy(['nriga' => SORT_ASC]);
    }
   public function getFilesall(){
       return $this->hasMany(allfiles::className(),['id_padre'=>'xid_testa']);
    }

    
  public function getDocRows()
{
    //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return $this->hasMany(Doc_rows::class, ['doc_head_id' => 'id']

)->orderBy(['nriga'=>SORT_ASC]);
}



public function getXrows($id){
$artdett=Doc_rows::find()
 ->where(['doc_head_id'=>$id])
->all();
//\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//$out = ['result'=>['']];
// $out['results'] = array_values($artdett);
return $artdett;

        }
}
