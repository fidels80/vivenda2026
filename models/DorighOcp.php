<?php

namespace app\models;

use Yii;

/**
 * Riga documento (DORig) con Cd_DO = 'OCP' (campagne pubblicitarie).
 * Modello in sola lettura sulla tabella DORig del database Arca (db2).
 *
 * @property int $Id_DORig
 * @property string $Cd_DOSottoCommessa
 * @property string $Cd_AR
 * @property string $Descrizione
 * @property float $Qta
 * @property string $x_cf
 * @property string $xdatainizio
 * @property string $xdatafine
 * @property string $x_cm
 * @property string $x_dn
 */
class DorighOcp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'DORig';
    }

    /**
     * {@inheritdoc}
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
            [['Id_DORig', 'Id_DOSottoCommessa'], 'integer'],
            [['Qta', 'x_dn'], 'number'],
            [['Cd_DOSottoCommessa', 'Cd_AR'], 'string', 'max' => 20],
            [['Descrizione'], 'string', 'max' => 80],
            [['x_cf'], 'string', 'max' => 7],
            [['xdatainizio', 'xdatafine'], 'safe'],
            [['x_cm'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id_DORig' => 'Id D Orig',
            'Cd_DOSottoCommessa' => 'Sottocommessa',
            'Cd_AR' => 'Articolo',
            'Descrizione' => 'Descrizione',
            'Qta' => 'Qta',
            'x_cf' => 'CLIENTE finale',
            'xdatainizio' => 'Data Inizio',
            'xdatafine' => 'Data Fine',
            'x_cm' => 'x_cm',
            'x_dn' => 'x_dn',
        ];
    }
}
