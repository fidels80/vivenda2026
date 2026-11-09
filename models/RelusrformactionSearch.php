<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Relusrformaction;

/**
 * RelusrformactionSearch represents the model behind the search form of `app\models\Relusrformaction`.
 */
class RelusrformactionSearch extends Relusrformaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user'], 'integer'],
            [['form'], 'safe'],
            [['read', 'write', 'delete', 'access'], 'boolean'],
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
        $query = Relusrformaction::find();

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
            'id_user' => $this->id_user,
            'read' => $this->read,
            'write' => $this->write,
            'delete' => $this->delete,
            'access' => $this->access,
        ]);

        $query->andFilterWhere(['like', 'form', $this->form]);

        return $dataProvider;
    }
}
