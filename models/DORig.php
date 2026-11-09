<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DORig".
 *
 * @property int $Id_DORig ID Univoco.
 * @property int $Id_DOTes ID di collegamento alla testa 
 * @property int $Contabile
 * @property string|null $NumeroDoc Numero documento.
 * @property string|null $DataDoc Data Documento
 * @property string|null $Cd_MGEsercizio Codice esercizio di magazzino.
 * @property string|null $Cd_DO
 * @property string|null $TipoDocumento Tipo documento
 * @property string|null $Cd_CF Codice Cliente/Fornitore 
 * @property string|null $Cd_LS_C Codice listino per i component
 * @property string|null $Cd_VL Codice Valuta. 
 * @property float $Cambio Valore del cambio.
 * @property int $Decimali Decimali della valuta 
 * @property int $DecimaliPrzUn Decimali per i prezzi unitari
 * @property int $Riga Numero progressivo della riga.
 * @property string|null $Cd_MGCausale
 * @property string $TipoPC
 * @property string|null $Cd_MG_P Codice del Magazzino di parten
 * @property string|null $Cd_MGUbicazione_P
 * @property string|null $Cd_MG_A Codice del Magazzino di Arrivo
 * @property string|null $Cd_MGUbicazione_A
 * @property string|null $Cd_AR Codice Articolo NULL se riga 
 * @property int|null $Id_DoDB
 * @property string|null $Descrizione Descrizione della riga di docu
 * @property string|null $Cd_ARMisura Codice unità di misura. Obbli
 * @property string|null $Cd_CGConto
 * @property string|null $Cd_Aliquota Codice aliquota IVA. Obbligat
 * @property string|null $Cd_Aliquota_E Eventuale codice di esenzione 
 * @property string|null $Cd_Aliquota_R Codice aliquota effettivo util
 * @property string|null $Cd_DOSottoCommessa Codice della Commessa
 * @property string|null $Cd_ARLotto Codice del lotto
 * @property string $TipoRigaRif Tipo Riga descrittiva : ''  =
 * @property float $Qta Quantità movimentata. Espress
 * @property float $FattoreToUM1 Fattore di conversione all'uni
 * @property float|null $QtaEvadibile Quantità Evadibile Espressa i
 * @property int|null $Id_DORig_Evade Id della riga che viene evasa 
 * @property float $QtaEvasa Quantità da evadere su un altr
 * @property float $PrezzoUnitarioV Prezzo unitario in Valuta. Vi
 * @property string $ScontoRiga Sconto della riga Viene gesti
 * @property float $PrezzoAddizionaleV Prezzo addizionale che va ad i
 * @property float $PrezzoTotaleV Valore (Prezzo/Costo) totale d
 * @property int $PrezzoTotaleMovFree Flag per determinare se il val
 * @property float $PrezzoTotaleMovE Prezzo totale di riga per la v
 * @property int $Omaggio Tipo di omaggio sulla riga:  
 * @property string $ProvvigioneRiga_1 Percentuale composta di provvi
 * @property string $ProvvigioneRiga_2 Percentuale composta di provvi
 * @property string|null $DataConsegna Data di Consegna ABL Default:
 * @property string|null $DataConsegna_R
 * @property string|null $NoteRiga Note sulla riga del documento.
 * @property int $Evasa Vale 1 (true) quando la riga è
 * @property int $Evadibile Flag che indica l'evadibilità 
 * @property int $Esecutivo
 * @property string|null $Reserved_1
 * @property string|null $PackListRef Codice x il Packing List
 * @property string|null $Cd_CAFormula
 * @property int $CAPartenza
 * @property int $CADurata
 * @property string|null $Cd_CAVda
 * @property string|null $Cd_CACda
 * @property string $ScontoAddizionale Sconto addizionale di riga
 * @property float $FattoreScontoRiga Fattore di sconto della riga
 * @property float $FattoreScontoAddizionale Fattore di sconto addizionale 
 * @property float $FattoreScontoTotale
 * @property float $FattoreProvv_1 Fattore relativo alla provvigi
 * @property float $FattoreProvv_2 Fattore relativo alla provvigi
 * @property string $ScontoTotale
 * @property int|null $Id_LSArticolo Collegamento con LSArticolo. L
 * @property int|null $Id_LSScaglione Collegamento con LSScaglione. 
 * @property string|null $RR_DataInizio
 * @property string|null $RR_DataFine
 * @property string|null $RR_Cd_CGConto
 * @property string|null $Matricole
 * @property string|null $ExtraInfo
 * @property string|null $NoteXML
 * @property string $UserIns
 * @property string $UserUpd
 * @property string $TimeIns
 * @property string $TimeUpd
 * @property string|null $Ts
 * @property int $ImportiIvati
 * @property string|null $FTE_Xml
 * @property string|null $Cd_ReverseCharge
 * @property int $DoIntentoFix
 * @property int|null $ExtraInfoPresent
 * @property float|null $xCostoAcquisto xCostoAcquisto
 * @property float|null $xTotCosto xTotCosto
 * @property int|null $xRigaPercRif xRigaPercRif
 * @property float|null $PrezzoResiduoV
 * @property float|null $PrezzoResiduoE
 * @property float $PrezzoTotaleE
 * @property float $PrezzoUnitarioScontatoV
 * @property float $ValProvvigione_1
 * @property float $ValProvvigione_2
 * @property string|null $xInserzione Nr Inserzione
 * @property int|null $xID_DOC_Ribaltato Id DOC Ribaltato
 * @property int|null $xID_MOV_Ribaltato Id MOV Ribaltato
 * @property float|null $xCostoAcquisto_Copy xCostoAcquisto Copia
 * @property float|null $xPrezzoUnitarioV_Copy xPrezzoUnitarioV Copia
 * @property string|null $xGazzetta Nr Gazzetta
 * @property int $xSoggettoRitAcconto Soggetto al calcolo della Rite
 * @property int $xSoggettoRitEnasarco Soggetto al calcolo della Rite
 * @property string|null $xRifRiga Riferimento descrittivo
 * @property string|null $xDataRichiestaCliente Data Richiesta Cliente
 * @property string|null $xNoteTecnici Note Tecnici
 * @property string|null $xEA_Inviata Data Invio Email
 * @property string|null $cd_xARFormato
 */
class DORig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'DORig';
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
            [['Id_DOTes', 'ScontoTotale', 'PrezzoTotaleE', 'PrezzoUnitarioScontatoV', 'ValProvvigione_1', 'ValProvvigione_2'], 'required'],
            [['Id_DOTes', 'Contabile', 'Decimali', 'DecimaliPrzUn', 'Riga', 'Id_DoDB', 'Id_DORig_Evade', 'PrezzoTotaleMovFree', 'Omaggio', 'Evasa', 'Evadibile', 'Esecutivo', 'CAPartenza', 'CADurata', 'Id_LSArticolo', 'Id_LSScaglione', 'ImportiIvati', 'DoIntentoFix', 'ExtraInfoPresent', 'xRigaPercRif', 'xID_DOC_Ribaltato', 'xID_MOV_Ribaltato', 'xSoggettoRitAcconto', 'xSoggettoRitEnasarco'], 'integer'],
            [['DataDoc', 'DataConsegna', 'DataConsegna_R', 'RR_DataInizio', 'RR_DataFine', 'TimeIns', 'TimeUpd', 'Ts', 'xDataRichiestaCliente', 'xEA_Inviata'], 'safe'],
            [['Cambio', 'Qta', 'FattoreToUM1', 'QtaEvadibile', 'QtaEvasa', 'PrezzoUnitarioV', 'PrezzoAddizionaleV', 'PrezzoTotaleV', 'PrezzoTotaleMovE', 'FattoreScontoRiga', 'FattoreScontoAddizionale', 'FattoreScontoTotale', 'FattoreProvv_1', 'FattoreProvv_2', 'xCostoAcquisto', 'xTotCosto', 'PrezzoResiduoV', 'PrezzoResiduoE', 'PrezzoTotaleE', 'PrezzoUnitarioScontatoV', 'ValProvvigione_1', 'ValProvvigione_2', 'xCostoAcquisto_Copy', 'xPrezzoUnitarioV_Copy'], 'number'],
            [['NoteRiga', 'Matricole', 'ExtraInfo', 'NoteXML', 'FTE_Xml', 'xNoteTecnici'], 'string'],
            [['NumeroDoc', 'Reserved_1', 'cd_xARFormato'], 'string', 'max' => 10],
            [['Cd_MGEsercizio'], 'string', 'max' => 4],
            [['Cd_DO', 'Cd_VL', 'Cd_MGCausale', 'Cd_Aliquota', 'Cd_Aliquota_E', 'Cd_Aliquota_R', 'Cd_ReverseCharge'], 'string', 'max' => 3],
            [['TipoDocumento', 'TipoPC', 'TipoRigaRif'], 'string', 'max' => 1],
            [['Cd_CF', 'Cd_LS_C'], 'string', 'max' => 7],
            [['Cd_MG_P', 'Cd_MG_A'], 'string', 'max' => 5],
            [['Cd_MGUbicazione_P', 'Cd_MGUbicazione_A', 'Cd_AR', 'Cd_DOSottoCommessa', 'Cd_ARLotto', 'ScontoRiga', 'PackListRef', 'Cd_CAFormula', 'Cd_CACda', 'ScontoAddizionale', 'xInserzione', 'xGazzetta'], 'string', 'max' => 20],
            [['Descrizione'], 'string', 'max' => 80],
            [['Cd_ARMisura'], 'string', 'max' => 2],
            [['Cd_CGConto', 'Cd_CAVda', 'RR_Cd_CGConto'], 'string', 'max' => 12],
            [['ProvvigioneRiga_1', 'ProvvigioneRiga_2'], 'string', 'max' => 16],
            [['ScontoTotale'], 'string', 'max' => 41],
            [['UserIns', 'UserUpd'], 'string', 'max' => 48],
            [['xRifRiga'], 'string', 'max' => 254],
            [['cd_xARFormato', 'Cd_AR'], 'exist', 'skipOnError' => true, 'targetClass' => XARFormato::className(), 'targetAttribute' => ['cd_xARFormato' => 'CD_xARFormato', 'Cd_AR' => 'CD_AR']],
            [['Cd_VL'], 'exist', 'skipOnError' => true, 'targetClass' => VL::className(), 'targetAttribute' => ['Cd_VL' => 'Cd_VL']],
            [['xID_DOC_Ribaltato'], 'exist', 'skipOnError' => true, 'targetClass' => CGMovT::className(), 'targetAttribute' => ['xID_DOC_Ribaltato' => 'Id_CGMovT']],
            [['xID_MOV_Ribaltato'], 'exist', 'skipOnError' => true, 'targetClass' => CGMovT::className(), 'targetAttribute' => ['xID_MOV_Ribaltato' => 'Id_CGMovT']],
            [['Cd_LS_C'], 'exist', 'skipOnError' => true, 'targetClass' => LS::className(), 'targetAttribute' => ['Cd_LS_C' => 'Cd_LS']],
            [['Cd_ARMisura'], 'exist', 'skipOnError' => true, 'targetClass' => ARMisura::className(), 'targetAttribute' => ['Cd_ARMisura' => 'Cd_ARMisura']],
            [['Cd_Aliquota'], 'exist', 'skipOnError' => true, 'targetClass' => Aliquota::className(), 'targetAttribute' => ['Cd_Aliquota' => 'Cd_Aliquota']],
            [['Cd_Aliquota_E'], 'exist', 'skipOnError' => true, 'targetClass' => Aliquota::className(), 'targetAttribute' => ['Cd_Aliquota_E' => 'Cd_Aliquota']],
            [['Cd_Aliquota_R'], 'exist', 'skipOnError' => true, 'targetClass' => Aliquota::className(), 'targetAttribute' => ['Cd_Aliquota_R' => 'Cd_Aliquota']],
            [['Cd_AR', 'Cd_ARLotto'], 'exist', 'skipOnError' => true, 'targetClass' => ARLotto::className(), 'targetAttribute' => ['Cd_AR' => 'Cd_AR', 'Cd_ARLotto' => 'Cd_ARLotto']],
            [['Cd_AR'], 'exist', 'skipOnError' => true, 'targetClass' => AR::className(), 'targetAttribute' => ['Cd_AR' => 'Cd_AR']],
            [['Cd_DO'], 'exist', 'skipOnError' => true, 'targetClass' => DO::className(), 'targetAttribute' => ['Cd_DO' => 'Cd_Do']],
            [['RR_Cd_CGConto'], 'exist', 'skipOnError' => true, 'targetClass' => CGConto::className(), 'targetAttribute' => ['RR_Cd_CGConto' => 'Cd_CGConto']],
            [['Cd_CGConto'], 'exist', 'skipOnError' => true, 'targetClass' => CGConto::className(), 'targetAttribute' => ['Cd_CGConto' => 'Cd_CGConto']],
            [['Cd_ReverseCharge'], 'exist', 'skipOnError' => true, 'targetClass' => ReverseCharge::className(), 'targetAttribute' => ['Cd_ReverseCharge' => 'Cd_ReverseCharge']],
            [['Cd_DOSottoCommessa'], 'exist', 'skipOnError' => true, 'targetClass' => DOSottoCommessa::className(), 'targetAttribute' => ['Cd_DOSottoCommessa' => 'Cd_DOSottoCommessa']],
            [['Id_LSScaglione'], 'exist', 'skipOnError' => true, 'targetClass' => LSScaglione::className(), 'targetAttribute' => ['Id_LSScaglione' => 'Id_LSScaglione']],
            [['Id_LSArticolo'], 'exist', 'skipOnError' => true, 'targetClass' => LSArticolo::className(), 'targetAttribute' => ['Id_LSArticolo' => 'Id_LSArticolo']],
            [['Cd_CAVda'], 'exist', 'skipOnError' => true, 'targetClass' => CAVda::className(), 'targetAttribute' => ['Cd_CAVda' => 'Cd_CAVda']],
            [['Cd_MGEsercizio'], 'exist', 'skipOnError' => true, 'targetClass' => MGEsercizio::className(), 'targetAttribute' => ['Cd_MGEsercizio' => 'Cd_MGEsercizio']],
            [['Cd_MG_P', 'Cd_MGUbicazione_P'], 'exist', 'skipOnError' => true, 'targetClass' => MGUbicazione::className(), 'targetAttribute' => ['Cd_MG_P' => 'Cd_MG', 'Cd_MGUbicazione_P' => 'Cd_MGUbicazione']],
            [['Cd_MG_A', 'Cd_MGUbicazione_A'], 'exist', 'skipOnError' => true, 'targetClass' => MGUbicazione::className(), 'targetAttribute' => ['Cd_MG_A' => 'Cd_MG', 'Cd_MGUbicazione_A' => 'Cd_MGUbicazione']],
            [['Cd_CAFormula'], 'exist', 'skipOnError' => true, 'targetClass' => CAFormula::className(), 'targetAttribute' => ['Cd_CAFormula' => 'Cd_CAFormula']],
            [['Cd_MG_A'], 'exist', 'skipOnError' => true, 'targetClass' => MG::className(), 'targetAttribute' => ['Cd_MG_A' => 'Cd_MG']],
            [['Cd_MG_P'], 'exist', 'skipOnError' => true, 'targetClass' => MG::className(), 'targetAttribute' => ['Cd_MG_P' => 'Cd_MG']],
            [['Cd_MGCausale'], 'exist', 'skipOnError' => true, 'targetClass' => MGCausale::className(), 'targetAttribute' => ['Cd_MGCausale' => 'Cd_MGCausale']],
            [['Id_DORig_Evade'], 'exist', 'skipOnError' => true, 'targetClass' => DORig::className(), 'targetAttribute' => ['Id_DORig_Evade' => 'Id_DORig']],
            [['Id_DOTes'], 'exist', 'skipOnError' => true, 'targetClass' => DOTes::className(), 'targetAttribute' => ['Id_DOTes' => 'Id_DoTes']],
            [['Id_DoDB'], 'exist', 'skipOnError' => true, 'targetClass' => DODB::className(), 'targetAttribute' => ['Id_DoDB' => 'Id_DoDB']],
            [['Cd_CACda'], 'exist', 'skipOnError' => true, 'targetClass' => CACda::className(), 'targetAttribute' => ['Cd_CACda' => 'Cd_CACda']],
            [['Cd_CF'], 'exist', 'skipOnError' => true, 'targetClass' => CF::className(), 'targetAttribute' => ['Cd_CF' => 'Cd_CF']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id_DORig' => 'ID Univoco.',
            'Id_DOTes' => 'ID di collegamento alla testa ',
            'Contabile' => 'Contabile',
            'NumeroDoc' => 'Numero documento.',
            'DataDoc' => 'Data Documento',
            'Cd_MGEsercizio' => 'Codice esercizio di magazzino.',
            'Cd_DO' => 'Cd Do',
            'TipoDocumento' => 'Tipo documento',
            'Cd_CF' => 'Codice Cliente/Fornitore
',
            'Cd_LS_C' => 'Codice listino per i component',
            'Cd_VL' => 'Codice Valuta.
',
            'Cambio' => 'Valore del cambio.',
            'Decimali' => 'Decimali della valuta
',
            'DecimaliPrzUn' => 'Decimali per i prezzi unitari',
            'Riga' => 'Numero progressivo della riga.',
            'Cd_MGCausale' => 'Cd Mg Causale',
            'TipoPC' => 'Tipo Pc',
            'Cd_MG_P' => 'Codice del Magazzino di parten',
            'Cd_MGUbicazione_P' => 'Cd Mg Ubicazione P',
            'Cd_MG_A' => 'Codice del Magazzino di Arrivo',
            'Cd_MGUbicazione_A' => 'Cd Mg Ubicazione A',
            'Cd_AR' => 'Codice Articolo
NULL se riga ',
            'Id_DoDB' => 'Id Do Db',
            'Descrizione' => 'Descrizione della riga di docu',
            'Cd_ARMisura' => 'Codice unità di misura.
Obbli',
            'Cd_CGConto' => 'Cd Cg Conto',
            'Cd_Aliquota' => 'Codice aliquota IVA.
Obbligat',
            'Cd_Aliquota_E' => 'Eventuale codice di esenzione ',
            'Cd_Aliquota_R' => 'Codice aliquota effettivo util',
            'Cd_DOSottoCommessa' => 'Codice della Commessa',
            'Cd_ARLotto' => 'Codice del lotto',
            'TipoRigaRif' => 'Tipo Riga descrittiva :
\'\'  =',
            'Qta' => 'Quantità movimentata.
Espress',
            'FattoreToUM1' => 'Fattore di conversione all\'uni',
            'QtaEvadibile' => 'Quantità Evadibile
Espressa i',
            'Id_DORig_Evade' => 'Id della riga che viene evasa ',
            'QtaEvasa' => 'Quantità da evadere su un altr',
            'PrezzoUnitarioV' => 'Prezzo unitario in Valuta.
Vi',
            'ScontoRiga' => 'Sconto della riga
Viene gesti',
            'PrezzoAddizionaleV' => 'Prezzo addizionale che va ad i',
            'PrezzoTotaleV' => 'Valore (Prezzo/Costo) totale d',
            'PrezzoTotaleMovFree' => 'Flag per determinare se il val',
            'PrezzoTotaleMovE' => 'Prezzo totale di riga per la v',
            'Omaggio' => 'Tipo di omaggio sulla riga:
 ',
            'ProvvigioneRiga_1' => 'Percentuale composta di provvi',
            'ProvvigioneRiga_2' => 'Percentuale composta di provvi',
            'DataConsegna' => 'Data di Consegna
ABL Default:',
            'DataConsegna_R' => 'Data Consegna R',
            'NoteRiga' => 'Note sulla riga del documento.',
            'Evasa' => 'Vale 1 (true) quando la riga è',
            'Evadibile' => 'Flag che indica l\'evadibilità ',
            'Esecutivo' => 'Esecutivo',
            'Reserved_1' => 'Reserved  1',
            'PackListRef' => 'Codice x il Packing List',
            'Cd_CAFormula' => 'Cd Ca Formula',
            'CAPartenza' => 'Ca Partenza',
            'CADurata' => 'Ca Durata',
            'Cd_CAVda' => 'Cd Ca Vda',
            'Cd_CACda' => 'Cd Ca Cda',
            'ScontoAddizionale' => 'Sconto addizionale di riga',
            'FattoreScontoRiga' => 'Fattore di sconto della riga',
            'FattoreScontoAddizionale' => 'Fattore di sconto addizionale ',
            'FattoreScontoTotale' => 'Fattore Sconto Totale',
            'FattoreProvv_1' => 'Fattore relativo alla provvigi',
            'FattoreProvv_2' => 'Fattore relativo alla provvigi',
            'ScontoTotale' => 'Sconto Totale',
            'Id_LSArticolo' => 'Collegamento con LSArticolo. L',
            'Id_LSScaglione' => 'Collegamento con LSScaglione. ',
            'RR_DataInizio' => 'Rr Data Inizio',
            'RR_DataFine' => 'Rr Data Fine',
            'RR_Cd_CGConto' => 'Rr Cd Cg Conto',
            'Matricole' => 'Matricole',
            'ExtraInfo' => 'Extra Info',
            'NoteXML' => 'Note Xml',
            'UserIns' => 'User Ins',
            'UserUpd' => 'User Upd',
            'TimeIns' => 'Time Ins',
            'TimeUpd' => 'Time Upd',
            'Ts' => 'Ts',
            'ImportiIvati' => 'Importi Ivati',
            'FTE_Xml' => 'Fte Xml',
            'Cd_ReverseCharge' => 'Cd Reverse Charge',
            'DoIntentoFix' => 'Do Intento Fix',
            'ExtraInfoPresent' => 'Extra Info Present',
            'xCostoAcquisto' => 'xCostoAcquisto',
            'xTotCosto' => 'xTotCosto',
            'xRigaPercRif' => 'xRigaPercRif',
            'PrezzoResiduoV' => 'Prezzo Residuo V',
            'PrezzoResiduoE' => 'Prezzo Residuo E',
            'PrezzoTotaleE' => 'Prezzo Totale E',
            'PrezzoUnitarioScontatoV' => 'Prezzo Unitario Scontato V',
            'ValProvvigione_1' => 'Val Provvigione  1',
            'ValProvvigione_2' => 'Val Provvigione  2',
            'xInserzione' => 'Nr Inserzione',
            'xID_DOC_Ribaltato' => 'Id DOC Ribaltato',
            'xID_MOV_Ribaltato' => 'Id MOV Ribaltato',
            'xCostoAcquisto_Copy' => 'xCostoAcquisto Copia',
            'xPrezzoUnitarioV_Copy' => 'xPrezzoUnitarioV Copia',
            'xGazzetta' => 'Nr Gazzetta',
            'xSoggettoRitAcconto' => 'Soggetto al calcolo della Rite',
            'xSoggettoRitEnasarco' => 'Soggetto al calcolo della Rite',
            'xRifRiga' => 'Riferimento descrittivo',
            'xDataRichiestaCliente' => 'Data Richiesta Cliente',
            'xNoteTecnici' => 'Note Tecnici',
            'xEA_Inviata' => 'Data Invio Email',
            'cd_xARFormato' => 'Cd X Ar Formato',
        ];
    }
}
