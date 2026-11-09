<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ana_cli".
 *
 * @property string $cd_cli
 * @property string $Desk
 * @property string|null $address
 * @property string|null $localita
 * @property string|null $cap
 * @property string|null $cd_nazione
 * @property string|null $PartitaIva
 * @property string|null $CodiceFiscale
 */
class Anacli extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ana_cli';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cd_cli', 'Desk'], 'required'],
            [['cd_cli'], 'string', 'max' => 7],
            [['Desk', 'address','ccemail'], 'string', 'max' => 80],
            [['localita'], 'string', 'max' => 60],
            [['cap'], 'string', 'max' => 10],
            [['cd_nazione'], 'string', 'max' => 2],
            [['PartitaIva'], 'string', 'max' => 17],
            [['CodiceFiscale'], 'string', 'max' => 16],
            [['showprices','show_ins_nrgaz'], 'integer'],
            [['cd_cli'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cd_cli' => 'Cd Cli',
            'Desk' => 'Desk',
            'address' => 'Address',
            'localita' => 'Localita',
            'cap' => 'Cap',
            'cd_nazione' => 'Cd Nazione',
            'PartitaIva' => 'Partita Iva',
            'CodiceFiscale' => 'Codice Fiscale',
            'ccemail'=>'Email CC',
            'showprices'=>'Mostra prezzi',
            'show_ins_nrgaz'=>'MOstra Inserzione e nr gazzetta'
        ];
    }

    public function getDestesall(){
        return $this->hasMany(CliDest::className(),['cd_cli'=>'cd_cli']);
    }

}
