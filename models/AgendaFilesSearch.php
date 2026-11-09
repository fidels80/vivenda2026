<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AgendaFiles;

/**
 * AgendafilesSearch represents the model behind the search form of `app\models\AgendaFiles`.
 */
class AgendafilesSearch extends AgendaFiles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_agenda'], 'integer'],
            [['descrizione', 'nota', 'f_content', 'nome_file', 'estenzione'], 'safe'],
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
        $query = AgendaFiles::find();

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
            'id_agenda' => $this->id_agenda,
        ]);

        $query->andFilterWhere(['like', 'descrizione', $this->descrizione])
            ->andFilterWhere(['like', 'nota', $this->nota])
            ->andFilterWhere(['like', 'f_content', $this->f_content])
            ->andFilterWhere(['like', 'nome_file', $this->nome_file])
            ->andFilterWhere(['like', 'estenzione', $this->estenzione]);

        return $dataProvider;
    }

}
