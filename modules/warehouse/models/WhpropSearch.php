<?php

namespace app\modules\warehouse\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\Whprop;

/**
 * WhpropSearch represents the model behind the search form of `app\models\Whprop`.
 */
class WhpropSearch extends Whprop
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',   'father'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['desk'], 'safe'],
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
        $query = Whprop::find();

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
            'code' => $this->code,
            'father' => $this->father,
        ]);

        $query->andFilterWhere(['like', 'desk', $this->desk]);

        return $dataProvider;
    }
}
