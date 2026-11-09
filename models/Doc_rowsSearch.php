<?php

namespace app\models;
use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Doc_rows;

/**
 * Doc_rowsSearch represents the model behind the search form of `app\models\Doc_rows`.
 */
class Doc_rowsSearch extends Doc_rows
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'doc_head_id', 'cd_art', 'descrizione', 'um', 'sconto', 'note', 'cd_doc', 'data', 'numdoc', 'cd_cli', 'iva'], 'safe'],
            [['qta', 'prezzo'], 'number'],
            [['xid_testa', 'xid_riga'], 'integer'],
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
        $cf=  Yii::$app->user->identity->cd_cli;
        $query = Doc_rows::find()
        ->where (['cd_cli'=>$cf]);

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
            'qta' => $this->qta,
            'prezzo' => $this->prezzo,
            'data' => $this->data,
            'xid_testa' => $this->xid_testa,
            'xid_riga' => $this->xid_riga,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'doc_head_id', $this->doc_head_id])
            ->andFilterWhere(['like', 'cd_art', $this->cd_art])
            ->andFilterWhere(['like', 'descrizione', $this->descrizione])
            ->andFilterWhere(['like', 'um', $this->um])
            ->andFilterWhere(['like', 'sconto', $this->sconto])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'cd_doc', $this->cd_doc])
            ->andFilterWhere(['like', 'numdoc', $this->numdoc])
            ->andFilterWhere(['like', 'cd_cli', $this->cd_cli])
            ->andFilterWhere(['like', 'iva', $this->iva]);

        return $dataProvider;
    }
}
