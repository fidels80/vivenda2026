<?php

//namespace app\models;
namespace app\modules\autoupdate\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\autoupdate\models\TblBrand;

/**
 * TblBrandSearch represents the model behind the search form of `app\models\TblBrand`.
 */
class TblBrandSearch extends TblBrand
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['code', 'desk', 'defa_path'], 'safe'],
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
        $query = TblBrand::find();

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

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'desk', $this->desk])
            ->andFilterWhere(['like', 'defa_path', $this->defa_path]);

        return $dataProvider;
    }
}
