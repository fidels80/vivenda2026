<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Elemail;

/**
 * ElemailSearch represents the model behind the search form of `app\models\Elemail`.
 */
class ElemailSearch extends Elemail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nome', 'email', 'Soggetto', 'Corpo', 'allegati','data'], 'safe'],
        //    [['data']]
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
        $query = Elemail::find();

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



        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'Soggetto', $this->Soggetto])
            ->andFilterWhere(['like', 'Corpo', $this->Corpo])
            ->andFilterWhere(['like', 'allegati', $this->allegati]);

            if(isset ($this->data)&&$this->data!=''){ //you dont need the if function if yourse sure you have a not null date
                $date_explode=explode(" - ",$this->data);
                $date1=trim($date_explode[0]);
                $date2=trim($date_explode[1]);
                $query->andFilterWhere(['between','data',$date1,$date2]);
              }



        return $dataProvider;
    }
}
