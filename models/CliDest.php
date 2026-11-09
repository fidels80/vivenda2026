<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cli_dest".
 *
 * @property string|null $cd_cli
 * @property string|null $cd_cli_dest
 * @property string|null $Descrizione
 * @property string|null $Address
 * @property string|null $cap
 * @property string|null $city
 * @property string|null $nation
 * @property int $id
 */
class CliDest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cli_dest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cd_cli'], 'string', 'max' => 7],
            [['cd_cli_dest'], 'string', 'max' => 3],
            [['Descrizione', 'Address', 'city'], 'string', 'max' => 80],
            [['cap'], 'string', 'max' => 10],
            [['nation'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cd_cli' => 'Cd Cli',
            'cd_cli_dest' => 'Cd Cli Dest',
            'Descrizione' => 'Descrizione',
            'Address' => 'Address',
            'cap' => 'Cap',
            'city' => 'City',
            'nation' => 'Nation',
            'id' => 'ID',
        ];
    }
}
