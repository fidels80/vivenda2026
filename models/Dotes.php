<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dotes".
 *
 * @property int $Id_DoTes ID Univoco autogenerato.
 * @property string $Cd_Do
 * @property string $TipoDocumento Tipologia di documento. ('F', 
 * @property int $DoBitMask
 * @property string $Cd_CF Codice cliente / fornitore. U
 * @property string|null $Cd_CF_Fatt Cliente / Fornitore cui fattua
 * @property string $Cd_CF_Fatt_R
 * @property string $CliFor  C = Documento Cliente F = D
 * @property string|null $Cd_Aliquota_E
 * @property string|null $Cd_CFDest
 * @property string|null $Cd_CFSede
 * @property string|null $Cd_CN Codice del contatore.
 * @property int $Ue
 * @property int $SegnoDocumento
 * @property int $Contabile
 * @property int $TipoFattura
 * @property int $ImportiIvati
 * @property int $IvaSospesa
 * @property int $Esecutivo Esecutività del documento (non
 * @property int $Prelevabile Prelevabilità del documento.
 * @property int $Modificabile Modificabilità del documento.
 * @property int $ModificabilePdf
 * @property string|null $NumeroDoc Numero documento formato da 6 
 * @property int $NumeroDocI
 * @property string $DataDoc Data documento. Se non specif
 * @property string|null $Cd_MGEsercizio Codice esercizio di magazzino.
 * @property string|null $EsAnno
 * @property string|null $Iban
 * @property string $Cd_Abicab
 * @property string|null $BicCode
 * @property string|null $Cd_CGConto_Banca
 * @property string|null $NumeroDocRif Numero del documento del Clien
 * @property string|null $DataDocRif Data documento del Cliente/For
 * @property string|null $DataConsegna Data Consegna. Attenzione: no
 * @property string|null $Cd_VL Codice Valuta ABL Default: CF
 * @property int $Decimali Numero di decimali della valut
 * @property int $DecimaliPrzUn Numero di decimali della valut
 * @property float $Cambio Valore del cambio. Si noti ch
 * @property string|null $Cd_MGCausale
 * @property int $MagPFlag
 * @property int $MagAFlag
 * @property string|null $Cd_LS_1
 * @property string|null $Cd_LS_2
 * @property string|null $Cd_LS_C
 * @property string|null $Cd_PG Codice di pagamento. ABL Defa
 * @property string|null $DataPag
 * @property string|null $Cd_Agente_1 Codice agente 1. ABL Default:
 * @property string|null $Cd_Agente_2 Codice agente 2. ABL Default:
 * @property string|null $Cd_CFZona Codice Zona. ABL Default: CF.
 * @property string|null $Cd_DoSottoCommessa Codice Commessa.
 * @property string $ScontoCassa Sconto Cassa espresso come str
 * @property string|null $NoteXML
 * @property string|null $Cd_DoTrasporto Causale trasporto. Default da
 * @property string|null $Cd_DoSped Codice spedizione. Default da
 * @property string|null $Cd_DoPorto Codice porto. Default da DO.
 * @property string|null $Cd_DoAspBene Aspetto esteriore dei beni. D
 * @property string|null $Cd_DoVettore_1 Codice primo vettore. ABL: De
 * @property string|null $Cd_DoVettore_2 Codice secondo vettore. ABL: 
 * @property string|null $Vettore1DataOra Data ritiro primo vettore.
 * @property string|null $Vettore2DataOra Data ritiro secondo vettore.
 * @property string|null $TrasportoDataora
 * @property string|null $Cd_DoCaricatore Codice caricatore. ABL: Defau
 * @property string|null $Cd_DoCommittente Codice committente. ABL: Defa
 * @property string|null $Cd_DoProprietarioMerce Codice prorietario merce. ABL
 * @property int $Colli Numero colli.
 * @property float $PesoLordo Peso Lordo.
 * @property float $PesoNetto Peso Netto.
 * @property float $VolumeTotale Volume.
 * @property string|null $NotePiede Note sul documento.
 * @property float $AbbuonoV Valore dell'abbuono.
 * @property int $RigheMerce
 * @property int $RigheSpesa
 * @property int $Righe
 * @property int $RigheMerceEvadibili
 * @property int $RigheSpesaEvadibili
 * @property int $RigheEvadibili
 * @property float $AccontoPerc
 * @property float $AccontoFissoV
 * @property float $AccontoV
 * @property string|null $SdTAltro
 * @property string|null $Cd_DoLuogoCarico
 * @property string|null $Cd_DoLuogoScarico
 * @property int $CGCorrispondenzaIvaMerce
 * @property string|null $FTE_Status
 * @property string|null $Reserved_1 Riservato per decidere in asp_
 * @property string $UserIns Nome dell'utente esecutore del
 * @property string $UserUpd Nome dell'utente esecutore del
 * @property string $TimeIns Data dell'inserimento del docu
 * @property string $TimeUpd Data dell'ultimo aggiornamento
 * @property string|null $Ts
 * @property string|null $FTE_Xml
 * @property int $IvaSplit
 * @property string|null $CD_ReverseCharge
 * @property string|null $Attributi
 * @property string|null $cd_xEmailAttach
 * @property string|null $xFatturaCliente Fattura Cliente
 * @property int|null $xID_FatturaCliente ID Fattura Cliente
 * @property string|null $Ud_FTE
 * @property int $xCalcolaRitenuta Calcola Ritenuta su fatture in
 * @property int $xCalcolaEnasarco Calcola Ritenuta Enasarco su f
 * @property float $xPercentualeRitenuta Percentuale Ritenuta d'acconto
 * @property float $xPercentualeEnasarco Percentuale Ritenuta Enasarco
 * @property float $xPercentualeImponibileRitenuta Percentuale Imponibile su cui 
 * @property float $xPercentualeImponibileEnasarco Percentuale Imponibile su cui 
 * @property float $xPercentualeContributoIntegrativo Percentuale Ritenuta d'acconto
 * @property int $xCalcolaContributoIntegrativo Calcola Contributo Integrativo
 * @property float $xImponibileEnasarcoV_Manuale Imponibile Enasarco inserito m
 * @property string|null $ExtraInfo
 * @property int|null $Id_Dotes_P_Fatt id di collegamento al document
 * @property string|null $Cd_CF_Auto Cedente per i documenti integr
 * @property string|null $Cd_xScontoCassa
 * @property int|null $Id_FactoringProject
 * @property string|null $FactoringEvent
 * @property string|null $x_scedilizia
 * @property float|null $x_scper
 * @property float|null $x_scimp
 * @property int|null $xconfermato
 * @property int|null $xannullato
 */
class Dotes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dotes';
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
            [['Cd_Do', 'Cd_CF', 'Cd_CF_Fatt_R', 'Ue', 'SegnoDocumento', 'NumeroDocI', 'Cd_Abicab', 'Righe', 'RigheEvadibili'], 'required'],
            [['DoBitMask', 'Ue', 'SegnoDocumento', 'Contabile', 'TipoFattura', 'ImportiIvati', 'IvaSospesa', 'Esecutivo', 'Prelevabile', 'Modificabile', 'ModificabilePdf', 'NumeroDocI', 'Decimali', 'DecimaliPrzUn', 'MagPFlag', 'MagAFlag', 'Colli', 'RigheMerce', 'RigheSpesa', 'Righe', 'RigheMerceEvadibili', 'RigheSpesaEvadibili', 'RigheEvadibili', 'CGCorrispondenzaIvaMerce', 'IvaSplit', 'xID_FatturaCliente', 'xCalcolaRitenuta', 'xCalcolaEnasarco', 'xCalcolaContributoIntegrativo', 'Id_Dotes_P_Fatt', 'Id_FactoringProject', 'xconfermato', 'xannullato'], 'integer'],
            [['DataDoc', 'DataDocRif', 'DataConsegna', 'DataPag', 'Vettore1DataOra', 'Vettore2DataOra', 'TrasportoDataora', 'TimeIns', 'TimeUpd', 'Ts'], 'safe'],
            [['Cambio', 'PesoLordo', 'PesoNetto', 'VolumeTotale', 'AbbuonoV', 'AccontoPerc', 'AccontoFissoV', 'AccontoV', 'xPercentualeRitenuta', 'xPercentualeEnasarco', 'xPercentualeImponibileRitenuta', 'xPercentualeImponibileEnasarco', 'xPercentualeContributoIntegrativo', 'xImponibileEnasarcoV_Manuale', 'x_scper', 'x_scimp'], 'number'],
            [['NoteXML', 'NotePiede', 'SdTAltro', 'FTE_Xml', 'Attributi', 'Ud_FTE', 'ExtraInfo', 'FactoringEvent'], 'string'],
            [['Cd_Do', 'Cd_Aliquota_E', 'Cd_CFDest', 'Cd_CFSede', 'Cd_CN', 'Cd_VL', 'Cd_MGCausale', 'Cd_Agente_1', 'Cd_Agente_2', 'Cd_CFZona', 'Cd_DoTrasporto', 'Cd_DoSped', 'Cd_DoPorto', 'Cd_DoAspBene', 'Cd_DoCaricatore', 'Cd_DoCommittente', 'Cd_DoProprietarioMerce', 'Cd_DoLuogoCarico', 'Cd_DoLuogoScarico', 'FTE_Status', 'CD_ReverseCharge'], 'string', 'max' => 3],
            [['TipoDocumento', 'CliFor'], 'string', 'max' => 1],
            [['Cd_CF', 'Cd_CF_Fatt', 'Cd_CF_Fatt_R', 'Cd_LS_1', 'Cd_LS_2', 'Cd_LS_C', 'Cd_CF_Auto'], 'string', 'max' => 7],
            [['NumeroDoc', 'Cd_Abicab', 'Reserved_1'], 'string', 'max' => 10],
            [['Cd_MGEsercizio', 'EsAnno', 'Cd_PG'], 'string', 'max' => 4],
            [['Iban'], 'string', 'max' => 34],
            [['BicCode'], 'string', 'max' => 11],
            [['Cd_CGConto_Banca'], 'string', 'max' => 12],
            [['NumeroDocRif', 'Cd_DoSottoCommessa', 'ScontoCassa', 'cd_xEmailAttach', 'Cd_xScontoCassa'], 'string', 'max' => 20],
            [['Cd_DoVettore_1', 'Cd_DoVettore_2'], 'string', 'max' => 2],
            [['UserIns', 'UserUpd'], 'string', 'max' => 48],
            [['xFatturaCliente'], 'string', 'max' => 100],
            [['x_scedilizia'], 'string', 'max' => 240],
            [['Cd_CN', 'EsAnno', 'NumeroDoc'], 'unique', 'targetAttribute' => ['Cd_CN', 'EsAnno', 'NumeroDoc']],
            [['xID_FatturaCliente'], 'exist', 'skipOnError' => true, 'targetClass' => DOTes::className(), 'targetAttribute' => ['xID_FatturaCliente' => 'Id_DoTes']],
            [['Cd_CF_Auto'], 'exist', 'skipOnError' => true, 'targetClass' => CF::className(), 'targetAttribute' => ['Cd_CF_Auto' => 'Cd_CF']],
            [['Id_Dotes_P_Fatt'], 'exist', 'skipOnError' => true, 'targetClass' => DOTes::className(), 'targetAttribute' => ['Id_Dotes_P_Fatt' => 'Id_DoTes']],
            [['Cd_VL'], 'exist', 'skipOnError' => true, 'targetClass' => VL::className(), 'targetAttribute' => ['Cd_VL' => 'Cd_VL']],
            [['Id_FactoringProject'], 'exist', 'skipOnError' => true, 'targetClass' => FactoringProject::className(), 'targetAttribute' => ['Id_FactoringProject' => 'Id_FactoringProject']],
            [['Cd_xScontoCassa'], 'exist', 'skipOnError' => true, 'targetClass' => XScontoCassa::className(), 'targetAttribute' => ['Cd_xScontoCassa' => 'Cd_xScontoCassa']],
            [['CD_ReverseCharge'], 'exist', 'skipOnError' => true, 'targetClass' => ReverseCharge::className(), 'targetAttribute' => ['CD_ReverseCharge' => 'Cd_ReverseCharge']],
            [['Cd_CN'], 'exist', 'skipOnError' => true, 'targetClass' => CN::className(), 'targetAttribute' => ['Cd_CN' => 'Cd_CN']],
            [['Cd_DoLuogoCarico'], 'exist', 'skipOnError' => true, 'targetClass' => DOSdTAnag::className(), 'targetAttribute' => ['Cd_DoLuogoCarico' => 'Cd_DOSdTAnag']],
            [['Cd_DoLuogoScarico'], 'exist', 'skipOnError' => true, 'targetClass' => DOSdTAnag::className(), 'targetAttribute' => ['Cd_DoLuogoScarico' => 'Cd_DOSdTAnag']],
            [['Cd_DoCaricatore'], 'exist', 'skipOnError' => true, 'targetClass' => DOSdTAnag::className(), 'targetAttribute' => ['Cd_DoCaricatore' => 'Cd_DOSdTAnag']],
            [['Cd_DoCommittente'], 'exist', 'skipOnError' => true, 'targetClass' => DOSdTAnag::className(), 'targetAttribute' => ['Cd_DoCommittente' => 'Cd_DOSdTAnag']],
            [['Cd_DoProprietarioMerce'], 'exist', 'skipOnError' => true, 'targetClass' => DOSdTAnag::className(), 'targetAttribute' => ['Cd_DoProprietarioMerce' => 'Cd_DOSdTAnag']],
            [['Cd_CFZona'], 'exist', 'skipOnError' => true, 'targetClass' => CFZona::className(), 'targetAttribute' => ['Cd_CFZona' => 'Cd_CFZona']],
            [['Cd_PG'], 'exist', 'skipOnError' => true, 'targetClass' => PG::className(), 'targetAttribute' => ['Cd_PG' => 'Cd_PG']],
            [['Cd_LS_1'], 'exist', 'skipOnError' => true, 'targetClass' => LS::className(), 'targetAttribute' => ['Cd_LS_1' => 'Cd_LS']],
            [['Cd_LS_2'], 'exist', 'skipOnError' => true, 'targetClass' => LS::className(), 'targetAttribute' => ['Cd_LS_2' => 'Cd_LS']],
            [['Cd_LS_C'], 'exist', 'skipOnError' => true, 'targetClass' => LS::className(), 'targetAttribute' => ['Cd_LS_C' => 'Cd_LS']],
            [['Cd_Aliquota_E'], 'exist', 'skipOnError' => true, 'targetClass' => Aliquota::className(), 'targetAttribute' => ['Cd_Aliquota_E' => 'Cd_Aliquota']],
            [['Cd_DoAspBene'], 'exist', 'skipOnError' => true, 'targetClass' => DOAspBene::className(), 'targetAttribute' => ['Cd_DoAspBene' => 'Cd_DOAspBene']],
            [['Cd_Do'], 'exist', 'skipOnError' => true, 'targetClass' => DO::className(), 'targetAttribute' => ['Cd_Do' => 'Cd_Do']],
            [['Cd_DoPorto'], 'exist', 'skipOnError' => true, 'targetClass' => DOPorto::className(), 'targetAttribute' => ['Cd_DoPorto' => 'Cd_DOPorto']],
            [['Cd_DoSottoCommessa'], 'exist', 'skipOnError' => true, 'targetClass' => DOSottoCommessa::className(), 'targetAttribute' => ['Cd_DoSottoCommessa' => 'Cd_DOSottoCommessa']],
            [['Cd_DoSped'], 'exist', 'skipOnError' => true, 'targetClass' => DOSped::className(), 'targetAttribute' => ['Cd_DoSped' => 'Cd_DOSped']],
            [['Cd_CF', 'Cd_CFSede'], 'exist', 'skipOnError' => true, 'targetClass' => CFSede::className(), 'targetAttribute' => ['Cd_CF' => 'Cd_CF', 'Cd_CFSede' => 'Cd_CFSede']],
            [['Cd_DoTrasporto'], 'exist', 'skipOnError' => true, 'targetClass' => DOTrasporto::className(), 'targetAttribute' => ['Cd_DoTrasporto' => 'Cd_DOTrasporto']],
            [['Cd_MGEsercizio'], 'exist', 'skipOnError' => true, 'targetClass' => MGEsercizio::className(), 'targetAttribute' => ['Cd_MGEsercizio' => 'Cd_MGEsercizio']],
            [['Cd_CGConto_Banca'], 'exist', 'skipOnError' => true, 'targetClass' => Banca::className(), 'targetAttribute' => ['Cd_CGConto_Banca' => 'Cd_CGConto']],
            [['Cd_MGCausale'], 'exist', 'skipOnError' => true, 'targetClass' => MGCausale::className(), 'targetAttribute' => ['Cd_MGCausale' => 'Cd_MGCausale']],
            [['Cd_Agente_2'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['Cd_Agente_2' => 'Cd_Agente']],
            [['Cd_Agente_1'], 'exist', 'skipOnError' => true, 'targetClass' => Agente::className(), 'targetAttribute' => ['Cd_Agente_1' => 'Cd_Agente']],
            [['Cd_DoVettore_2'], 'exist', 'skipOnError' => true, 'targetClass' => DOVettore::className(), 'targetAttribute' => ['Cd_DoVettore_2' => 'Cd_DoVettore']],
            [['cd_xEmailAttach'], 'exist', 'skipOnError' => true, 'targetClass' => XEmailAttach::className(), 'targetAttribute' => ['cd_xEmailAttach' => 'Cd_xEmailAttach']],
            [['Cd_DoVettore_1'], 'exist', 'skipOnError' => true, 'targetClass' => DOVettore::className(), 'targetAttribute' => ['Cd_DoVettore_1' => 'Cd_DoVettore']],
            [['Cd_CF', 'Cd_CFDest'], 'exist', 'skipOnError' => true, 'targetClass' => CFDest::className(), 'targetAttribute' => ['Cd_CF' => 'Cd_CF', 'Cd_CFDest' => 'Cd_CFDest']],
            [['Cd_CF_Fatt'], 'exist', 'skipOnError' => true, 'targetClass' => CF::className(), 'targetAttribute' => ['Cd_CF_Fatt' => 'Cd_CF']],
            [['Cd_CF'], 'exist', 'skipOnError' => true, 'targetClass' => CF::className(), 'targetAttribute' => ['Cd_CF' => 'Cd_CF']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id_DoTes' => 'ID Univoco autogenerato.',
            'Cd_Do' => 'Cd Do',
            'TipoDocumento' => 'Tipologia di documento. (\'F\', ',
            'DoBitMask' => 'Do Bit Mask',
            'Cd_CF' => 'Codice cliente / fornitore.
U',
            'Cd_CF_Fatt' => 'Cliente / Fornitore cui fattua',
            'Cd_CF_Fatt_R' => 'Cd Cf Fatt R',
            'CliFor' => '
C = Documento Cliente
F = D',
            'Cd_Aliquota_E' => 'Cd Aliquota E',
            'Cd_CFDest' => 'Cd Cf Dest',
            'Cd_CFSede' => 'Cd Cf Sede',
            'Cd_CN' => 'Codice del contatore.',
            'Ue' => 'Ue',
            'SegnoDocumento' => 'Segno Documento',
            'Contabile' => 'Contabile',
            'TipoFattura' => 'Tipo Fattura',
            'ImportiIvati' => 'Importi Ivati',
            'IvaSospesa' => 'Iva Sospesa',
            'Esecutivo' => 'Esecutività del documento (non',
            'Prelevabile' => 'Prelevabilità del documento.',
            'Modificabile' => 'Modificabilità del documento.',
            'ModificabilePdf' => 'Modificabile Pdf',
            'NumeroDoc' => 'Numero documento formato da 6 ',
            'NumeroDocI' => 'Numero Doc I',
            'DataDoc' => 'Data documento.
Se non specif',
            'Cd_MGEsercizio' => 'Codice esercizio di magazzino.',
            'EsAnno' => 'Es Anno',
            'Iban' => 'Iban',
            'Cd_Abicab' => 'Cd Abicab',
            'BicCode' => 'Bic Code',
            'Cd_CGConto_Banca' => 'Cd Cg Conto Banca',
            'NumeroDocRif' => 'Numero del documento del Clien',
            'DataDocRif' => 'Data documento del Cliente/For',
            'DataConsegna' => 'Data Consegna.
Attenzione: no',
            'Cd_VL' => 'Codice Valuta
ABL Default: CF',
            'Decimali' => 'Numero di decimali della valut',
            'DecimaliPrzUn' => 'Numero di decimali della valut',
            'Cambio' => 'Valore del cambio.
Si noti ch',
            'Cd_MGCausale' => 'Cd Mg Causale',
            'MagPFlag' => 'Mag P Flag',
            'MagAFlag' => 'Mag A Flag',
            'Cd_LS_1' => 'Cd Ls  1',
            'Cd_LS_2' => 'Cd Ls  2',
            'Cd_LS_C' => 'Cd Ls C',
            'Cd_PG' => 'Codice di pagamento.
ABL Defa',
            'DataPag' => 'Data Pag',
            'Cd_Agente_1' => 'Codice agente 1.
ABL Default:',
            'Cd_Agente_2' => 'Codice agente 2.
ABL Default:',
            'Cd_CFZona' => 'Codice Zona.
ABL Default: CF.',
            'Cd_DoSottoCommessa' => 'Codice Commessa.',
            'ScontoCassa' => 'Sconto Cassa espresso come str',
            'NoteXML' => 'Note Xml',
            'Cd_DoTrasporto' => 'Causale trasporto.
Default da',
            'Cd_DoSped' => 'Codice spedizione.
Default da',
            'Cd_DoPorto' => 'Codice porto.
Default da DO.',
            'Cd_DoAspBene' => 'Aspetto esteriore dei beni.
D',
            'Cd_DoVettore_1' => 'Codice primo vettore.
ABL: De',
            'Cd_DoVettore_2' => 'Codice secondo vettore.
ABL: ',
            'Vettore1DataOra' => 'Data ritiro primo vettore.',
            'Vettore2DataOra' => 'Data ritiro secondo vettore.',
            'TrasportoDataora' => 'Trasporto Dataora',
            'Cd_DoCaricatore' => 'Codice caricatore.
ABL: Defau',
            'Cd_DoCommittente' => 'Codice committente.
ABL: Defa',
            'Cd_DoProprietarioMerce' => 'Codice prorietario merce.
ABL',
            'Colli' => 'Numero colli.',
            'PesoLordo' => 'Peso Lordo.',
            'PesoNetto' => 'Peso Netto.',
            'VolumeTotale' => 'Volume.',
            'NotePiede' => 'Note sul documento.',
            'AbbuonoV' => 'Valore dell\'abbuono.',
            'RigheMerce' => 'Righe Merce',
            'RigheSpesa' => 'Righe Spesa',
            'Righe' => 'Righe',
            'RigheMerceEvadibili' => 'Righe Merce Evadibili',
            'RigheSpesaEvadibili' => 'Righe Spesa Evadibili',
            'RigheEvadibili' => 'Righe Evadibili',
            'AccontoPerc' => 'Acconto Perc',
            'AccontoFissoV' => 'Acconto Fisso V',
            'AccontoV' => 'Acconto V',
            'SdTAltro' => 'Sd T Altro',
            'Cd_DoLuogoCarico' => 'Cd Do Luogo Carico',
            'Cd_DoLuogoScarico' => 'Cd Do Luogo Scarico',
            'CGCorrispondenzaIvaMerce' => 'Cg Corrispondenza Iva Merce',
            'FTE_Status' => 'Fte Status',
            'Reserved_1' => 'Riservato per decidere in asp_',
            'UserIns' => 'Nome dell\'utente esecutore del',
            'UserUpd' => 'Nome dell\'utente esecutore del',
            'TimeIns' => 'Data dell\'inserimento del docu',
            'TimeUpd' => 'Data dell\'ultimo aggiornamento',
            'Ts' => 'Ts',
            'FTE_Xml' => 'Fte Xml',
            'IvaSplit' => 'Iva Split',
            'CD_ReverseCharge' => 'Cd Reverse Charge',
            'Attributi' => 'Attributi',
            'cd_xEmailAttach' => 'Cd X Email Attach',
            'xFatturaCliente' => 'Fattura Cliente',
            'xID_FatturaCliente' => 'ID Fattura Cliente',
            'Ud_FTE' => 'Ud Fte',
            'xCalcolaRitenuta' => 'Calcola Ritenuta su fatture in',
            'xCalcolaEnasarco' => 'Calcola Ritenuta Enasarco su f',
            'xPercentualeRitenuta' => 'Percentuale Ritenuta d\'acconto',
            'xPercentualeEnasarco' => 'Percentuale Ritenuta Enasarco',
            'xPercentualeImponibileRitenuta' => 'Percentuale Imponibile su cui ',
            'xPercentualeImponibileEnasarco' => 'Percentuale Imponibile su cui ',
            'xPercentualeContributoIntegrativo' => 'Percentuale Ritenuta d\'acconto',
            'xCalcolaContributoIntegrativo' => 'Calcola Contributo Integrativo',
            'xImponibileEnasarcoV_Manuale' => 'Imponibile Enasarco inserito m',
            'ExtraInfo' => 'Extra Info',
            'Id_Dotes_P_Fatt' => 'id di collegamento al document',
            'Cd_CF_Auto' => 'Cedente per i documenti integr',
            'Cd_xScontoCassa' => 'Cd X Sconto Cassa',
            'Id_FactoringProject' => 'Id Factoring Project',
            'FactoringEvent' => 'Factoring Event',
            'x_scedilizia' => 'X Scedilizia',
            'x_scper' => 'X Scper',
            'x_scimp' => 'X Scimp',
            'xconfermato' => 'Xconfermato',
            'xannullato' => 'Xannullato',
        ];
    }
}
