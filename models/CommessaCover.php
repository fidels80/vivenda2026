<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Copertina (immagine) associata a una sottocommessa.
 * Tabella locale `commessa_cover` nel database web_frontier.
 *
 * @property int $id
 * @property string $cd_dosottocommessa
 * @property string $image_path
 * @property string $created_at
 * @property string $updated_at
 */
class CommessaCover extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commessa_cover';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('GETDATE()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cd_dosottocommessa', 'image_path'], 'required'],
            [['cd_dosottocommessa'], 'string', 'max' => 20],
            [['image_path'], 'string', 'max' => 255],
            [['cd_dosottocommessa'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cd_dosottocommessa' => 'Codice sottocommessa',
            'image_path' => 'Percorso immagine',
            'created_at' => 'Creato il',
            'updated_at' => 'Aggiornato il',
        ];
    }
}
