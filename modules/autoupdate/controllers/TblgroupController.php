<?php

namespace app\modules\autoupdate\controllers;
use Yii;
use app\modules\autoupdate\models\TblGroup;
use app\modules\autoupdate\models\TblGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\autoupdate\models\Rlsbrdgrp;
use app\modules\autoupdate\models\Tblshop;

/**
 * TblGroupController implements the CRUD actions for TblGroup model.
 */
class TblgroupController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TblGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
   
        $searchModel = new TblGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    

    /**
     * Displays a single TblGroup model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
    
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Creates a new TblGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
 
        $model = new TblGroup();
          if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $rel= new Rlsbrdgrp();
              $rel->setAttribute('brand_id',$model['brand_id']);
                      $rel->setAttribute('group_id',$model['id']);
                      $rel->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
    return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    /**
     * Updates an existing TblGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
     
         $model = $this->findModel($id);
         $model->load(Yii::$app->request->post()) ;
         $lista = $model->lista;
         $tmpl=$lista;
         $lista2=$model->lista2;
         $tmpl2=$lista2;
         $gruppo=$model->id;
       //ricordarti di trovare un metodo per evitare questa zozzeria e creare i campi dinamici! 
         $model->setAttribute('lista' ,null);
         $model->setAttribute('lista2' ,null);
         if ( $model->save()) {
     // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
     // return $tmpl;
     // $ar_list=  explode(',', $lista);;
         $connection= \Yii::$app->db;
         if (is_null($tmpl)==true  or $tmpl==""){
         $connection->createCommand()
        ->update('tbl_shop', ['brand_grp_id' => 0], 'brand_grp_id =  ('.$gruppo.')')
        ->execute(); 
         }else {
         $connection->createCommand()
        ->update('tbl_shop', ['brand_grp_id' => $model->id,'flag'=>0], 'id in  ('.$lista.')')
        ->execute();
         // $connection= \Yii::$app->db;
        if ($tmpl2<>"" or is_null($tmpl2)==false  ) {
         $connection->createCommand()
        ->update('tbl_shop', ['brand_grp_id' =>0], 'id in  ('.$lista2.')')
        ->execute();
        }
    
           
           
       }
            
            
            return   $this->redirect(['index']);//$this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    

    /**
     * Deletes an existing TblGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
     
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * Finds the TblGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TblGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
      
        if (($model = TblGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
      public function actionList() {
     
  Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       Yii::info("azione");
       $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
          //  $list = Contact::find()->andWhere(['id_ana_ref' => $id])->asArray()->all();
         Yii::info("sono dentro e l'id è".$id);
            $query= new \yii\db\Query();
         $query  -> select('tbl_group.id  as id,tbl_group.desk as name')
               ->from('tbl_group') 
               ->leftjoin('rls_brd_grp'  , 'rls_brd_grp.group_id = tbl_group.id')
             ->where(['rls_brd_grp.brand_id' => $id]);
       //        ->queryAll();
        $rows=$query->all();
    $command=$query->createCommand();
    $data= $command->queryAll();
   // yii:warning(var_dump($query));
    foreach ($data as $i=>$t){
   
     Yii::info("sono dentro e l'il risultato  è    ".$t['name']);
     Yii::info("sono dentro e l'id  è    ".$t['id']);
  //          var_dump($data);
     $out[] = ['id' => $t['id'], 'name' => $t['name']];
      $selected = $t['id'];
    // $out[] = ['id' => 1000, 'name' => 'query'];
      
    }

     return ['output' => $out, 'selected' => $selected];
        }
 else {$query= new \yii\db\Query();
         $query  -> select( 'id,desk as name')
               ->from('tbl_group');
       // $rows=$query->all();
    $command=$query->createCommand();
    $data= $command->queryAll();
    $out[] = array_values($data);
    return $out;
    
 }
       
    }

public function actionForzadown($idgrp){
    
    //return $id;
    // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $query= new \yii\db\Query();
         $query  -> select('id  as id,desk as descrizione')
               ->from('tbl_shop') 
             //  ->leftjoin('rls_brd_grp'  , 'rls_brd_grp.group_id = tbl_group.id')
             ->where(['brand_grp_id' => $idgrp]);
         $command=$query->createCommand();
    $data= $command->queryAll();
    $out[] = array_values($data);
    $response='';
    foreach ($data as $row  ) {
        $response=$response.$row['descrizione'].', ';
}
    $connection= \Yii::$app->db;
   // return '$response';
          $connection->createCommand()
        ->update('tbl_shop', ['upd' => 0], 'brand_grp_id = ('.$idgrp.')')
        ->execute();
           Yii::$app->session->setFlash('info', "aggiornato gruppo contenente i seguenti negozi".$response);
          return "aggiornato gruppo contenente i seguenti negozi: ".$response;//$this->redirect(['index']); 
        }


public function actionAss($id){
     
      $model = $this->findModel($id);
     
     return $this->render('ass__', [
            'model' =>$model
        ]);
     
     
 }
 
 
 
 public function actionSync($id,array $nass, array $lib){
     
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
     
      
      if (Yii::$app->request->get()) {
    $data = Yii::$app->request->get('nass');
       return $data;
}
      else {
          return 'nopost';
      }
      
       }
 
 public function actionTest_(){
     
       $result= yii::$app->runAction('relusrformaction/getursper',['cont'=>Yii::$app->controller->id,'act'=>Yii::$app->controller->action->id]);
  
      // yii::warning($result);
       if ($result==0){
       return 'non sei autorizzato!';
        
    } else {
    return $result;    
    }
     
 }
 
 
       
       
       
       
      }
  
