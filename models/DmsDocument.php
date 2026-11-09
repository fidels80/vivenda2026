<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DmsDocument".
 *
 * @property int $Id_DmsDocument
 * @property int|null $Id_DmsDocument_Parent
 * @property int $Id_DmsClass1
 * @property int $Id_DmsClass2
 * @property string $DmsClass3
 * @property string $Cd_DmsType
 * @property string $Tipo
 * @property string $DocumentDate
 * @property string $Descrizione
 * @property string $DescrizioneEx
 * @property string $NumeroRif
 * @property string|null $Note
 * @property string|null $EntityId
 * @property string|null $EntityTable
 * @property string|null $MasterEntityId
 * @property string|null $MasterEntityTable
 * @property string|null $MixedEntityTable
 * @property string|null $MixedEntityId
 * @property int $MixedIsMaster
 * @property string|null $EntityDescription
 * @property int $LinkedToFS
 * @property int $LinkedToEntity
 * @property resource|null $Content
 * @property int $Ciphered
 * @property int $ContentSize
 * @property string $ComputerName
 * @property string|null $FilePath
 * @property string $FileName
 * @property string $FileExt
 * @property int $FileSize
 * @property string $Tag TAG per riconosce tipo record.
 * @property int|null $Id_ARKmanager
 * @property int $ARK_State
 * @property string $UserIns
 * @property string $UserUpd
 * @property string $TimeIns
 * @property string $TimeUpd
 * @property string $Ts
 * @property int $Use4Fepa
 * @property int $Use4FepaEx
 * @property int|null $IdFatturaRX
 * @property string|null $FTEInfo
 * @property int|null $Id_VdA
 * @property string|null $Id_PdV
 * @property string|null $Attributi
 * @property string|null $WebDesk Riferimenti invio a WebDesk
 * @property string|null $Ud_CSmart
 * @property int $Use4Peppol
 */
class DmsDocument extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'DmsDocument';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id_DmsDocument_Parent', 'Id_DmsClass1', 'Id_DmsClass2', 'MixedIsMaster', 'LinkedToFS', 'LinkedToEntity', 'Ciphered', 'ContentSize', 'FileSize', 'Id_ARKmanager', 'ARK_State', 'Use4Fepa', 'Use4FepaEx', 'IdFatturaRX', 'Id_VdA', 'Use4Peppol'], 'integer'],
            [['DocumentDate', 'Descrizione', 'DescrizioneEx', 'MixedIsMaster', 'LinkedToFS', 'LinkedToEntity', 'ContentSize', 'FileName', 'FileExt', 'FileSize', 'Ts', 'Use4Fepa', 'Use4FepaEx', 'Use4Peppol'], 'required'],
            [['DocumentDate', 'TimeIns', 'TimeUpd', 'Ts'], 'safe'],
            [['Note', 'EntityId', 'MasterEntityId', 'MixedEntityId', 'EntityDescription', 'Content', 'FTEInfo', 'Attributi', 'WebDesk', 'Ud_CSmart'], 'string'],
            [['DmsClass3', 'NumeroRif'], 'string', 'max' => 20],
            [['Cd_DmsType'], 'string', 'max' => 2],
            [['Tipo'], 'string', 'max' => 1],
            [['Descrizione'], 'string', 'max' => 200],
            [['DescrizioneEx'], 'string', 'max' => 219],
            [['EntityTable', 'MasterEntityTable', 'MixedEntityTable'], 'string', 'max' => 128],
            [['ComputerName', 'Id_PdV'], 'string', 'max' => 50],
            [['FilePath', 'FileName', 'FileExt'], 'string', 'max' => 260],
            [['Tag'], 'string', 'max' => 3],
            [['UserIns', 'UserUpd'], 'string', 'max' => 48],
            [['Id_DmsDocument_Parent'], 'exist', 'skipOnError' => true, 'targetClass' => DmsDocument::className(), 'targetAttribute' => ['Id_DmsDocument_Parent' => 'Id_DmsDocument']],
            [['Id_DmsClass1', 'Id_DmsClass2'], 'exist', 'skipOnError' => true, 'targetClass' => DmsClass2::className(), 'targetAttribute' => ['Id_DmsClass1' => 'Id_DmsClass1', 'Id_DmsClass2' => 'Id_DmsClass2']],
            [['Cd_DmsType'], 'exist', 'skipOnError' => true, 'targetClass' => DmsType::className(), 'targetAttribute' => ['Cd_DmsType' => 'Cd_DmsType']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id_DmsDocument' => 'Id Dms Document',
            'Id_DmsDocument_Parent' => 'Id Dms Document Parent',
            'Id_DmsClass1' => 'Id Dms Class 1',
            'Id_DmsClass2' => 'Id Dms Class 2',
            'DmsClass3' => 'Dms Class 3',
            'Cd_DmsType' => 'Cd Dms Type',
            'Tipo' => 'Tipo',
            'DocumentDate' => 'Document Date',
            'Descrizione' => 'Descrizione',
            'DescrizioneEx' => 'Descrizione Ex',
            'NumeroRif' => 'Numero Rif',
            'Note' => 'Note',
            'EntityId' => 'Entity ID',
            'EntityTable' => 'Entity Table',
            'MasterEntityId' => 'Master Entity ID',
            'MasterEntityTable' => 'Master Entity Table',
            'MixedEntityTable' => 'Mixed Entity Table',
            'MixedEntityId' => 'Mixed Entity ID',
            'MixedIsMaster' => 'Mixed Is Master',
            'EntityDescription' => 'Entity Description',
            'LinkedToFS' => 'Linked To Fs',
            'LinkedToEntity' => 'Linked To Entity',
            'Content' => 'Content',
            'Ciphered' => 'Ciphered',
            'ContentSize' => 'Content Size',
            'ComputerName' => 'Computer Name',
            'FilePath' => 'File Path',
            'FileName' => 'File Name',
            'FileExt' => 'File Ext',
            'FileSize' => 'File Size',
            'Tag' => 'TAG per riconosce tipo record.',
            'Id_ARKmanager' => 'Id Ar Kmanager',
            'ARK_State' => 'Ark State',
            'UserIns' => 'User Ins',
            'UserUpd' => 'User Upd',
            'TimeIns' => 'Time Ins',
            'TimeUpd' => 'Time Upd',
            'Ts' => 'Ts',
            'Use4Fepa' => 'Use 4 Fepa',
            'Use4FepaEx' => 'Use 4 Fepa Ex',
            'IdFatturaRX' => 'Id Fattura Rx',
            'FTEInfo' => 'Fte Info',
            'Id_VdA' => 'Id Vd A',
            'Id_PdV' => 'Id Pd V',
            'Attributi' => 'Attributi',
            'WebDesk' => 'Riferimenti invio a WebDesk',
            'Ud_CSmart' => 'Ud C Smart',
            'Use4Peppol' => 'Use 4 Peppol',
        ];
    }
}
