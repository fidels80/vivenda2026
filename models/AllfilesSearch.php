<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Allfiles;

/**
 * AllfilesSearch represents the model behind the search form of `app\models\Allfiles`.
 */
class AllfilesSearch extends Allfiles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['id_padre', 'f_content', 'entita', 'nomefile', 'estensione'], 'safe'],
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
        $query = Allfiles::find();

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
        ]);

        $query->andFilterWhere(['like', 'id_padre', $this->id_padre])
            ->andFilterWhere(['like', 'f_content', $this->f_content])
            ->andFilterWhere(['like', 'entita', $this->entita])
            ->andFilterWhere(['like', 'nomefile', $this->nomefile])
            ->andFilterWhere(['like', 'estensione', $this->estensione]);

        return $dataProvider;
    }
}
