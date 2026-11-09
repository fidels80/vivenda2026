<?php

namespace app\modules\presenze\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\presenze\models\Presenze;

/**
 * PresenzeSearch represents the model behind the search form of `app\modules\presenze\models\Presenze`.
 */
class PresenzeSearch extends Presenze
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['tran', 'idterm', 'datarec'], 'safe'],
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
        $query = Presenze::find();

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
            'datarec' => $this->datarec,
        ]);

        $query->andFilterWhere(['like', 'tran', $this->tran])
            ->andFilterWhere(['like', 'idterm', $this->idterm]);

        return $dataProvider;
    }
}
