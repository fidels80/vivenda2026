<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rep_publicazioni".
 *
 * @property string|null $cd_cf
 * @property string|null $cd_Art
 * @property string|null $descrizione
 * @property string|null $datacons
 * @property string|null $Cd_DOSottoCommessa
 * @property string|null $Cd_DO
 * @property float|null $PrezzoUnitarioScontatoV
 * @property float|null $Qta
 * @property float|null $PrezzoTotaleE
 * @property string|null $Cd_ARMarca
 * @property int $Id_DORig
 */
class Rep_publicazioni extends \yii\db\ActiveRecord
{
    public $moduli;
    public $prezzovendita;
    public $przmedio;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rep_publicazioni';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datacons'], 'safe'],
            [['PrezzoUnitarioScontatoV', 'Qta', 'PrezzoTotaleE'], 'number'],
            [['Id_DORig'], 'required'],
            [['Id_DORig'], 'integer'],
            [['cd_cf'], 'string', 'max' => 7],
            [['cd_Art'], 'string', 'max' => 50],
            [['descrizione'], 'string', 'max' => 80],
            [['Cd_DOSottoCommessa', 'Cd_ARMarca'], 'string', 'max' => 20],
            [['Cd_DO'], 'string', 'max' => 3],
            [['Id_DORig'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cd_cf' => 'Cd Cf',
            'cd_Art' => 'Cd Art',
            'descrizione' => 'Descrizione',
            'datacons' => 'Datacons',
            'Cd_DOSottoCommessa' => 'Cd Do Sotto Commessa',
            'Cd_DO' => 'Cd Do',
            'PrezzoUnitarioScontatoV' => 'Prezzo Unitario Scontato V',
            'Qta' => 'Qta',
            'PrezzoTotaleE' => 'Prezzo Totale E',
            'Cd_ARMarca' => 'Cd Ar Marca',
            'Id_DORig' => 'Id Do Rig',
        ];
    }
}
