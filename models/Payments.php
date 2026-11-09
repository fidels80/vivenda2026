<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property int|null $xid_testa
 * @property string $cd_cli
 * @property string|null $Cd_PG
 * @property string $DataScadenza
 * @property string|null $DataPagamento
 * @property string|null $DataFattura
 * @property string|null $NumFattura
 * @property string|null $Protocollo
 * @property int $Pagata
 * @property int $NumEffetto
 * @property int $TotEffetti
 * @property float $ImportoV
 * @property float $IncassoV
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['xid_testa', 'Pagata', 'NumEffetto', 'TotEffetti'], 'integer'],
            [['cd_cli', 'DataScadenza', 'Pagata', 'NumEffetto', 'TotEffetti', 'ImportoV', 'IncassoV'], 'required'],
            [['DataScadenza', 'DataPagamento', 'DataFattura'], 'safe'],
            [['ImportoV', 'IncassoV'], 'number'],
            [['cd_cli'], 'string', 'max' => 7],
            [['Cd_PG'], 'string', 'max' => 4],
            [['NumFattura'], 'string', 'max' => 20],
            [['Protocollo'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'xid_testa' => 'Xid Testa',
            'cd_cli' => 'Cd Cli',
            'Cd_PG' => 'Cd Pg',
            'DataScadenza' => 'Data Scadenza',
            'DataPagamento' => 'Data Pagamento',
            'DataFattura' => 'Data Fattura',
            'NumFattura' => 'Num Fattura',
            'Protocollo' => 'Protocollo',
            'Pagata' => 'Pagata',
            'NumEffetto' => 'Num Effetto',
            'TotEffetti' => 'Tot Effetti',
            'ImportoV' => 'Importo V',
            'IncassoV' => 'Incasso V',
        ];
    }


    public function gethead(){

        return $this->hasOne(doc_head::className(),['xid_testa'=>'xid_testa']);

    }
}
