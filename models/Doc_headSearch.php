<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Doc_head;

/**
 * Doc_headSearch represents the model behind the search form of `app\models\Doc_head`.
 */
class Doc_headSearch extends Doc_head
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cd_doc', 'data', 'numdoc', 'cd_cli', 'cd_pg', 'sconto',
            'confermato','rifiutato',
             'note','dest'], 'safe'],
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
      
if (Yii::$app->user->identity->level<>100) {
    $cf=  Yii::$app->user->identity->cd_cli;
    if ($cf<>'C000065'){
        $query = Doc_head::find()
            ->where(['cd_cli'=>$cf])
        //    ->andWhere(['<>','cd_doc','OVC'])
            ->orWhere(['altcli'=>$cf]);
        }else {
    $query = Doc_head::find()
            ->where(['cd_cli'=>$cf])
            ->andWhere(['<>','cd_doc','OVC'])
            ->orWhere(['altcli'=>$cf]);
        
    
        }
}else {
 $query = Doc_head::find();

}

$request = Yii::$app->request;


$get = $request->get();
// equivalent to: $get = $_GET;

$fc = $request->get('filtra_confermato');
$fr= $request->get('filtra_rifiutato');


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['xid_testa' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return
            // any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
      //  $query->andFilterWhere([
       //     'data' => $this->data,
      //  ]);

 

if(isset($fc)){
$query->andFilterWhere([  'confermato'=> $fc]);
}
if (isset($fr)) {
    $query->andFilterWhere(['rifiutato' => $fr]);
}

        if(isset ($this->data)&&$this->data!=''){ //you dont need the if function if yourse sure you have a not null date
            $date_explode=explode(" - ",$this->data);
            $date1=trim($date_explode[0]);
            $date2=trim($date_explode[1]);
            $query->andFilterWhere(['between','data',$date1,$date2]);
          }

//if (Yii::$app->user->identity->level<>100) {
    $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'cd_doc', $this->cd_doc])
            ->andFilterWhere(['like', 'numdoc', $this->numdoc])
            ->andFilterWhere(['like', 'cd_cli', $this->cd_cli])
            ->andFilterWhere(['like', 'cd_pg', $this->cd_pg])
            ->andFilterWhere(['like', 'sconto', $this->sconto])
            ->andFilterWhere(['confermato'=> $this->confermato])
            ->andFilterWhere(['rifiutato'=> $this->rifiutato])
             ->andFilterWhere(['like', 'dest', $this->dest])
            ->andFilterWhere(['like', 'note', $this->note]);
            //->sort->defaultOrder = ['xid_testa' => SORT_DESC];
/*}else{
//$query->andFilterWhere(['like', 'id', $this->id])
    ->andFilterWhere(['like', 'cd_doc', $this->cd_doc])
    ->andFilterWhere(['like', 'numdoc', $this->numdoc])
    ->andFilterWhere(['like', 'cd_cli', $this->cd_cli])
    ->andFilterWhere(['like', 'cd_pg', $this->cd_pg])
    ->andFilterWhere(['like', 'sconto', $this->sconto])
    ->andFilterWhere(['confermato' => $this->confermato])
    ->andFilterWhere(['rifiutato' => $this->rifiutato])
    ->andFilterWhere(['like', 'note', $this->note]);


'sort'=> ['defaultOrder' => ['topic_order' => SORT_ASC]],

//}
*/
        return $dataProvider;
    }
}
