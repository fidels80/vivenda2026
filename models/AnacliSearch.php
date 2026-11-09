<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Anacli;
use app\models\User;
/**
 * AnacliSearch represents the model behind the search form of `app\models\Anacli`.
 */
class AnacliSearch extends Anacli
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cd_cli', 'Desk', 'address', 'localita', 'cap', 'cd_nazione', 'PartitaIva', 'CodiceFiscale'], 'safe'],
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
        $query = Anacli::find();

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
        $subQuery = user::find()->select('cd_cli')->distinct();
        $query->where(['in','cd_cli',$subQuery]);
        // grid filtering conditions
        $query->andFilterWhere(['like', 'cd_cli', $this->cd_cli])
            ->andFilterWhere(['like', 'Desk', $this->Desk])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'localita', $this->localita])
            ->andFilterWhere(['like', 'cap', $this->cap])
            ->andFilterWhere(['like', 'cd_nazione', $this->cd_nazione])
            ->andFilterWhere(['like', 'PartitaIva', $this->PartitaIva])
            ->andFilterWhere(['like', 'CodiceFiscale', $this->CodiceFiscale]);

        return $dataProvider;
    }
}
