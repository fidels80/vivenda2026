<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property string $id
 * @property string|null $titolo
 * @property string|null $editore
 * @property string|null $issn_isbn
 * @property string|null $formato
 * @property float|null $prezzo
 * @property string|null $link
 * @property string|null $data_inizio
 * @property string|null $datafine
 * @property int|null $attivo
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'string'],
            [['prezzo'], 'number'],
            [['data_inizio', 'datafine'], 'safe'],
            [['attivo'], 'integer'],
            [['titolo', 'editore', 'issn_isbn', 'formato', 'link'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titolo' => 'Titolo',
            'editore' => 'Editore',
            'issn_isbn' => 'Issn Isbn',
            'formato' => 'Formato',
            'prezzo' => 'Prezzo',
            'link' => 'Link',
            'data_inizio' => 'Data Inizio',
            'datafine' => 'Datafine',
            'attivo' => 'Attivo',
        ];
    }
}
