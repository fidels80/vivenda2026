<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Log;

/**
 * LogSearch represents the model behind the search form of `app\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'userid'], 'integer'],
            [['operazione', 'valore', 'old_valore', 'timeins'], 'safe'],
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
        $query = Log::find();

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
            'userid' => $this->userid,
            'timeins' => $this->timeins,
        ]);

        $query->andFilterWhere(['like', 'operazione', $this->operazione])
            ->andFilterWhere(['like', 'valore', $this->valore])
            ->andFilterWhere(['like', 'old_valore', $this->old_valore]);

        return $dataProvider;
    }
}
