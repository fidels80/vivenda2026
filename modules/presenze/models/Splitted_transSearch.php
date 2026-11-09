<?php

namespace app\modules\presenze\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\presenze\models\Splitted_trans;

/**
 * Splitted_transSearch represents the model behind the search form of `app\modules\presenze\models\Splitted_trans`.
 */
class Splitted_transSearch extends Splitted_trans
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'sorgente', 'esitocc', 'presenze_id'], 'integer'],
            [['data', 'ora', 'codicepersonale', 'x'], 'safe'],
            [['direzione'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Splitted_trans::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'sorgente' => $this->sorgente,
            'direzione' => $this->direzione,
            'esitocc' => $this->esitocc,
            'presenze_id' => $this->presenze_id,
        ]);

        $query->andFilterWhere(['like', 'data', $this->data])
            ->andFilterWhere(['like', 'ora', $this->ora])
            ->andFilterWhere(['like', 'codicepersonale', $this->codicepersonale])
            ->andFilterWhere(['like', 'x', $this->x]);

        return $dataProvider;
    }
}
