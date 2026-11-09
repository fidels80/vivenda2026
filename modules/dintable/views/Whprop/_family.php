<?php
use app\modules\warehouse\models\whprop;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView as kgrid;
/* @var $this yii\web\View */
/* @var $searchModel app\models\WhpropSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Whprops_family';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="whprop-index">

    <h1><?= Html::encode($this->title) ?></h1>

    
                <input  id='search' class="form-control mr-sm-2" name="q" type="text" placeholder="Search"
                       aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" onclick="finds();" >Search</button>
                <button onclick="resets();" class="btn btn-outline-secondary ml-2">RESET</button>
 

    <?php Pjax::begin(); ?>
    <?php

 $rows= whprop::find()->all();

    $i=0;
     
    echo "<table class='table table-bordered' width='100%' ><tr>";
    foreach ($rows as $row) {
      $tdname='';
          $tdname=str_replace(' ', '_',strtoupper($row->desk)); 
          if ($row['father']== 0) {
          $tddesk=whprop::find()->where(['father'=>$row['id']])->andwhere(['>=','father','1'])->all();
          if (!empty($tddesk)){
            foreach ($tddesk as $tddesks) {
              $tdname=$tdname.'|'.str_replace(' ', '_',strtoupper($tddesks->desk));
              }
          }
        }

        /*  echo "<td name={$tdname}><div id={$row->id}>
          <h4> Code {$row->id} </br>
      Description  {$row->desk}</h4>";*/
      echo "<td name={$tdname}><div id={$row->id}>";
      echo " <input type=\"checkbox\" id=\"{$row->id}\"   value=\"screen\">";
      echo " <label   for=\"{$row->id}\">({$row->id}){$row->desk}</label>";

        if ($row['father']== 0) {
            $srows= whprop::find()->where(['father'=>$row['id']])->andwhere(['>=','father','1'])->all();
            if (!empty($srows)){
        //    echo "Sons <ul>";
        $tname='';
        foreach ($srows as $ssrow) {
        $tname=$tname.strtoupper($ssrow->desk);
        }
        echo "<table class='table' name=\"{$tname}\">";


            foreach ($srows as $ssrow) {
              $tmpdsk=strtoupper($ssrow->desk);
              echo "<tr><td name=\"{$tmpdsk}\" class='tablechild' >";
            //    echo "<li>({$ssrow->id}, {$ssrow->desk});</li>";
            echo " <input type=\"checkbox\" id=\"{$ssrow->id}\"   value=\"screen\">";
            echo " <label   for=\"{$ssrow->id}\">{$ssrow->desk}</label>";
            echo "</td></tr> ";
        
        }
        echo "</table>";
          //  echo "</ul>";
        }
        }
        echo " </div></td>";
        $i=$i+1;
        if($i % 5 == 0){
           echo "</tr><tr>";
        }
      //  echo $i. "</br>";

};
echo "</table>";
?>
    <?php Pjax::end(); ?>

</div>
