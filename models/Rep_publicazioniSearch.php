<?php

namespace app\models;
use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rep_publicazioni;
use yii\data\SqlDataProvider;
/**
 * Rep_publicazioniSearch represents the model behind the search form of `app\models\Rep_publicazioni`.
 */
class Rep_publicazioniSearch extends Rep_publicazioni
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cd_cf', 'cd_Art', 'descrizione', 'datacons', 'Cd_DOSottoCommessa', 'Cd_DO', 'Cd_ARMarca'], 'safe'],
            [['PrezzoUnitarioScontatoV', 'Qta', 'PrezzoTotaleE'], 'number'],
            [['Id_DORig'], 'integer'],
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
//die();

if (Yii::$app->user->identity->level != 100) {
    $cf = Yii::$app->user->identity->cd_cli;
    //die($cf);
    $query = Rep_publicazioni::find()
        ->where(['cd_Cf' => $cf]);
      //  ->orWhere(['altcli' => $cf]);
} else {
    $query = Rep_publicazioni::find() ->where(['cd_Cf' => $cf]);

}
 
 
       // $query = Rep_publicazioni::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

if (Yii::$app->controller->action->id=='pub_marca') {
   //die('ASDA');
   $sql='SELECT  cd_armarca,descrizione,Cd_DOSottoCommessa,sum(qta) as moduli ,
avg(PrezzoUnitarioScontatoV) as przmedio,sum(qta*PrezzoUnitarioScontatoV) prezzovendita,cd_Cf
  FROM [web_frontier].[dbo].[rep_publicazioni]
where cd_cf=\'C004241\'
  group by cd_armarca,descrizione ,Cd_DOSottoCommessa,cd_Cf';
$query=/*'SELECT  cd_armarca,descrizione,Cd_DOSottoCommessa,sum(qta) as moduli ,
avg(PrezzoUnitarioScontatoV) as przmedio,sum(qta*PrezzoUnitarioScontatoV) prezzovendita,cd_Cf
  FROM [web_frontier].[dbo].[rep_publicazioni]
  where cd_cf=:cf
  group by cd_armarca,descrizione ,Cd_DOSottoCommessa,cd_Cf';
*/
//rep_publicazioni::findBySql($sql);
//yii::error($query);
/*->select('rOW_NUMBER() OVER(PARTITION BY cd_cf ORDER BY cd_armarca ASC)  as id,
Cd_ARMarca,descrizione,Cd_DOSottoCommessa,SUM(Qta) as [Moduli],
AVG(PrezzoUnitarioScontatoV) as [Przmedio],sum(Qta*PrezzoUnitarioScontatoV) as [Prezzovendita],cd_cf')
->where(['cd_cf'=>$cf])->groupBy(['cd_armarca','descrizione' ,'Cd_DOSottoCommessa','cd_Cf']);
*/
/*
$count=
*/
Rep_publicazioni::find()
->select(['Cd_ARMarca','descrizione','Cd_DOSottoCommessa','SUM([[Qta]]) as  moduli',
'AVG([[PrezzoUnitarioScontatoV]]) as przmedio',
'sum(Qta*PrezzoUnitarioScontatoV) as prezzovendita'])
->where(['cd_cf'=>$cf])
->groupBy(['Cd_ARMarca','descrizione','Cd_DOSottoCommessa']);
//->all();//->count();
/*$dataProvider= new SqlDataProvider([
                'sql' => 'SELECT  cd_armarca,descrizione,Cd_DOSottoCommessa,sum(qta) as moduli ,
avg(PrezzoUnitarioScontatoV) as przmedio,sum(qta*PrezzoUnitarioScontatoV) prezzovendita,cd_Cf
  FROM [web_frontier].[dbo].[rep_publicazioni]
  where cd_cf=:cf
  group by cd_armarca,descrizione ,Cd_DOSottoCommessa,cd_Cf',
                'params'=>[':cf'=>$cf],

'totalCount' =>$count,

]);*/

$query2= Rep_publicazioni::findBySql('SELECT  cd_armarca,descrizione,Cd_DOSottoCommessa,sum(Qta) as moduli ,
avg(PrezzoUnitarioScontatoV) as przmedio,sum(Qta*PrezzoUnitarioScontatoV) prezzovendita,cd_Cf
  FROM [web_frontier].[dbo].[rep_publicazioni]
--//where cd_cf=\'C004241\'
  group by cd_armarca,descrizione ,Cd_DOSottoCommessa,cd_Cf');



   $dataProvider = new ActiveDataProvider([
    'query' => $query,//
]);

$this->load($params);

}


yii::error($dataProvider);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
if (isset($this->datacons) && $this->datacons != '') { //you dont need the if function if yourse sure you have a not null date
    $date_explode = explode(" - ", $this->datacons);
    $date1 = trim($date_explode[0]);
    $date2 = trim($date_explode[1]);
    $query->andFilterWhere(['between', 'datacons', $date1, $date2]);
}
if (Yii::$app->controller->action->id<>'pub_marca') {
        // grid filtering conditions
        $query->andFilterWhere([
          //  'datacons' => $this->datacons,
            'PrezzoUnitarioScontatoV' => $this->PrezzoUnitarioScontatoV,
            'Qta' => $this->Qta,
            'PrezzoTotaleE' => $this->PrezzoTotaleE,
            'Id_DORig' => $this->Id_DORig,
        ]);
    
        $query->andFilterWhere(['like', 'cd_cf', $this->cd_cf])
            ->andFilterWhere(['like', 'cd_Art', $this->cd_Art])
            ->andFilterWhere(['like', 'descrizione', $this->descrizione])
            ->andFilterWhere(['like', 'Cd_DOSottoCommessa', $this->Cd_DOSottoCommessa])
            ->andFilterWhere(['like', 'Cd_DO', $this->Cd_DO])
            ->andFilterWhere(['like', 'Cd_ARMarca', $this->Cd_ARMarca]);
    }
    else{
 
  $query-> andFilterWhere(['like', 'Cd_DOSottoCommessa', $this->Cd_DOSottoCommessa])
   ->andFilterWhere(['like', 'Cd_ARMarca', $this->Cd_ARMarca])
 ->andFilterWhere(['like', 'descrizione', $this->descrizione]);
 

    }
        return $dataProvider;
    }
}
