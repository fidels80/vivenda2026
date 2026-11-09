<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Blkins;

/**
 * BlkinsSearch represents the model behind the search form of `app\models\Blkins`.
 */
class BlkinsSearch extends Blkins
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'importato'], 'integer'],
            [['CC_CLIENTE', 'agente', 'Tipo_evento', 'Codice_progetto', 'descrizione', 'note'], 'safe'],
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
        $query = Blkins::find();

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
            'importato' => $this->importato,
        ]);

        $query->andFilterWhere(['like', 'CC_CLIENTE', $this->CC_CLIENTE])
            ->andFilterWhere(['like', 'agente', $this->agente])
            ->andFilterWhere(['like', 'Tipo_evento', $this->Tipo_evento])
            ->andFilterWhere(['like', 'Codice_progetto', $this->Codice_progetto])
            ->andFilterWhere(['like', 'descrizione', $this->descrizione])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
