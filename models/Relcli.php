<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "relcli".
 *
 * @property int $id
 * @property string $cd_cli
 * @property string $altcli
 */
class Relcli extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relcli';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cd_cli', 'altcli'], 'required'],
            [['cd_cli', 'altcli'], 'string', 'max' => 7],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cd_cli' => 'Cd Cli',
            'altcli' => 'Altcli',
        ];
    }
}
