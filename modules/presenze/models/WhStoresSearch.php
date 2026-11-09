<?php

///namespace app\models;
namespace app\modules\dintable\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Whstores;

/**
 * WhstoresSearch represents the model behind the search form of `app\models\Whstores`.
 */
class WhstoresSearch extends Whstores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'city', 'zone', 'nation'], 'integer'],
            [['code', 'desk', 'address'], 'safe'],
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
        $query = Whstores::find();

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
            'city' => $this->city,
            'zone' => $this->zone,
            'nation' => $this->nation,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'desk', $this->desk])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
