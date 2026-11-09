<style>
        .large-icon {
            font-size: 330px; /* Puoi regolare questa dimensione a piacere */
            color: #007bff; /* Colore blu */
        }
        .full-page-search {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Altezza totale della viewport */
        background-color: #f5f5f5; /* Colore di sfondo */
        text-align: center;
    }
    .search-form {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        max-width: 600px; /* Larghezza massima del form */
        margin: 0 auto;
    }
    .search-input {
        flex: 1;
        padding: 15px;
        font-size: 18px;
        border: 1px solid #ccc;
        border-radius: 4px 0 0 4px; /* Bordo arrotondato solo a sinistra */
        box-sizing: border-box;
        margin: 0;
    }
    .search-button {
        padding: 15px;
        font-size: 18px;
        border: none;
        border-radius: 0 4px 4px 0; /* Bordo arrotondato solo a destra */
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }
    .search-button:hover {
        background-color: #0056b3;
    }
    </style>
 
<?php
$this->title = 'Home Page';
//$this->params['breadcrumbs'] = [['label' => $this->title]];
use app\models\doc_head;
use app\models\payments;
use app\models\User;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
try {
    $cf = Yii::$app->user->identity->cd_cli;
} catch (Exception $e) {
    $usrid = '';
    $ris   = (new \yii\db\Query())
        ->select(['cd_cli', 'email', 'username', 'piva'])
        ->from('user')
        ->where(['id' => $usrid])
        ->one();

    $cf = $ris['cd_cli'] ?? '';
}
//yii::error($cf);
//C004207
$altteste =
/*
doc_head::find()->select(['xid_testa','id'])->where(['altcli'=>$cd_cf])//->andwhere('is not',['altcli'=>null])
->limit(5)->all();
 */
(new \yii\db\Query())
    ->select(['xid_testa'])
    ->from('doc_head')
    ->where(['=', 'altcli', $cf])
    ->andwhere(['IS NOT', 'altcli', null])
    ->all();

//yii::warning($altteste);
$filtro = [];
foreach ($altteste as $value) {
    $filtro[] = $value['xid_testa'];
}
//yii::warning($filtro);

if ('C000065' != $cf) {
    $totdoc  = doc_head::find()->where(['cd_cli' => $cf])->count();
    $totdocC = doc_head::find()->where(['confermato' => 1, 'cd_cli' => $cf])->count();
} else {

    $totdoc  = doc_head::find()->where(['cd_cli' => $cf])->andWhere(['<>', 'cd_doc', 'OVC'])->count();
    $totdocC = doc_head::find()->where(['confermato' => 1, 'cd_cli' => $cf])
        ->andWhere(['<>', 'cd_doc', 'OVC'])->count();

    $query = Doc_head::find()
        ->where(['cd_cli' => $cf])
        ->andWhere(['<>', 'cd_doc', 'OVC'])
        ->orWhere(['altcli' => $cf]);

}

$totsc = payments::find()->where(['cd_cli' => $cf])->orwhere(['IN', 'xid_testa', $filtro])->count();

$totsc_pagata = payments::find()->where(['cd_cli' => $cf, 'Pagata' => '1'])->
    orwhere(['and', ['IN', 'xid_testa', $filtro], ['Pagata' => '1']])->count();

$dapagare = payments::find()->where(['cd_cli' => $cf, 'Pagata' => '0'])->
    orwhere(['and', ['IN', 'xid_testa', $filtro], ['Pagata' => '0']])->sum('ImportoV');

$pagato = payments::find()->where(['cd_cli' => $cf, 'Pagata' => '1'])->
    orwhere(['and', ['IN', 'xid_testa', $filtro], ['Pagata' => '1']])->sum('ImportoV');

$connection = Yii::$app->getDb();
$command    = $connection->createCommand("select mese,sum(tot)as tot from (
select month(DataScadenza) as mese ,sum(importov) as tot from payments
where cd_cli=:id_cli /*and year(DataScadenza)=2022 */
and pagata=1 --or (xid_testa in (select xid_testa from doc_head where altcli=:id_cli) and pagata=1)

group by year(DataScadenza),month(DataScadenza)
union
select month(DataScadenza) as mese ,sum(importov) as tot from payments
where (payments.xid_testa in (select xid_testa from doc_head where altcli='C004241') and payments.pagata=1)
group by year(DataScadenza),month(DataScadenza)

union
select 1 as mese,0
union
select 2 as mese,0
union
select 3 as mese,0
union
select 4 as mese,0
union
select 5 as mese,0
union
select 6 as mese,0
union
select 7 as mese,0
union
select 8 as mese,0
union
select 9 as mese,0
union
select 10 as mese,0
union
select 11 as mese,0
union
select 12 as mese,0
) as t
group by mese

", [':id_cli' => $cf]);

$result = $command->queryAll();

$command2 = $connection->createCommand("select mese,sum(tot)as tot from (
select month(DataScadenza) as mese ,sum(importov) as tot from payments
where (cd_cli=:id_cli /*and year(DataScadenza)=2022*/ and pagata<>1)
--or (payments.xid_testa in (select xid_testa from doc_head where altcli=:id_cli) and payments.pagata<>1)
group by year(DataScadenza),month(DataScadenza)
union
select month(DataScadenza) as mese ,sum(importov) as tot from payments
where (payments.xid_testa in (select xid_testa from doc_head where altcli='C004241') and payments.pagata<>1)
group by year(DataScadenza),month(DataScadenza)

union
select 1 as mese,0
union
select 2 as mese,0
union
select 3 as mese,0
union
select 4 as mese,0
union
select 5 as mese,0
union
select 6 as mese,0
union
select 7 as mese,0
union
select 8 as mese,0
union
select 9 as mese,0
union
select 10 as mese,0
union
select 11 as mese,0
union
select 12 as mese,0
) as t
group by mese

", [':id_cli' => $cf]);
$result2 = $command2->queryAll();
$righe   = [];
$righe2  = [];
foreach ($result as $value) {
    $righe[] = $value['tot'];
}
foreach ($result2 as $value) {
    $righe2[] = $value['tot'];
}

$series = [

    [
        'name' => "Pagate",
        'data' => $righe, //[45,46,1,3,0,0,0,0,0,1,1,1]
    ],
    [
        'name' => 'non Pagate',
        'data' => $righe2,

    ],

]
;

?>
 <?php if ($cf == 'C004207'): ?>
        <div class="book-search">
            <form action="<?= Url::to(['book/index']) ?>" method="get" class="search-form">
                <input type="text" name="BookSearch[titolo]" placeholder="Cerca" class="search-input"/>
                <input type="hidden" name="BookSearch[editore]" value=""/>
                <input type="hidden" name="BookSearch[issn_isbn]" value=""/>
                <input type="hidden" name="BookSearch[formato]" value=""/>
                <input type="hidden" name="BookSearch[prezzo]" value=""/>
                <input type="hidden" name="BookSearch[link]" value=""/>
                <input type="hidden" name="BookSearch[attivo]" value=""/>
                <input type="hidden" name="BookSearch[data_inizio]" value=""/>
                <input type="hidden" name="BookSearch[datafine]" value=""/>
                <input type="hidden" name="r" value="book"/> <!-- Questo campo nascosto aggiunge il parametro mancante -->
         
                <button type="submit" class="btn btn-primary search-button">Cerca</button>
            </form>
        </div>
    <?php endif; ?>

<br>
<div class="container-fluid">
<!--
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <?=\hail812\adminlte\widgets\InfoBox::widget([
    'text'   => 'File Presenti',
    'number' => '50 <small></small>',
    'icon'   => 'fas fa-copy',
])?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?=\hail812\adminlte\widgets\InfoBox::widget([
    'text'   => 'Saldo Da Pagare',
    'number' => round($dapagare, 2) . ' <small></small>',
    'icon'   => 'fas fa-calendar',
])?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?=\hail812\adminlte\widgets\InfoBox::widget([
    'text'   => 'Saldato',
    'number' => round($pagato, 2) . ' <small></small>',
    'icon'   => 'fas fa-calendar',
])?>
        </div>
    </div>

            -->


    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?=\hail812\adminlte\widgets\SmallBox::widget([
    'title'    => $totdoc,
    'text'     => 'Documenti Presenti in Archivio',
    'icon'     => 'far fa-copy',
    'linkText' => 'Apri',
    'linkUrl'  => Url::to(['doc_head/index']),
])?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">


         <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
    'title'    => $totdocC,
    'text'     => 'Documenti Confermati',
    'icon'     => 'far fa-copy',
    'theme'    => 'success',
    'linkText' => 'Apri',
    'linkUrl'  => Url::to(['doc_head/index', 'filtra_confermato' => true]),
])?>
            <?php echo \hail812\adminlte\widgets\Ribbon::widget([
    'id'       => $smallBox->id . '-ribbon',
    'text'     => 'Confermati',
    'theme'    => 'warning',
    'size'     => 'lg',

    'textSize' => 'lg',
])?>
            <?php \hail812\adminlte\widgets\SmallBox::end()?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?php if ('C004207'<>$cf):?>
        <?php 
        $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
    'title'    => $totdoc - $totdocC,
    'text'     => 'Documenti da Confermare',
    'icon'     => 'far fa-copy',
    'theme'    => 'Info',
    'linkText' => 'Apri',
    'linkUrl'  => Url::to(['doc_head/index', 'filtra_confermato' => false]),

        ]);
    
?>
            <?=\hail812\adminlte\widgets\Ribbon::widget([
    'id'       => $smallBox->id . '-ribbon',
    'text'     => 'Non Confermati',
    'theme'    => 'warning',
    'size'     => 'lg',
    'textSize' => 'sm',
])?>
            <?php \hail812\adminlte\widgets\SmallBox::end()?>
            <?php endif?>
        </div>
    </div>
   <!-- ///////////////////////////////////////////////////-->
    <div class="row">
    <?php if ('C004207'<>$cf):?>   
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?=\hail812\adminlte\widgets\SmallBox::widget([
    'title'    => $totsc,
    'text'     => 'Totali scadenze',
    'icon'     => 'far fa-calendar',
    'linkText' => 'Apri',
    'linkUrl'  => Url::to(['payments/index']),
])?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">


         <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
    'title'    => $totsc_pagata,
    'text'     => 'Scadenze Pagate',
    'icon'     => 'far fa-calendar',
    'theme'    => 'success',
    'linkText' => 'Apri',
    'linkUrl'  => Url::to(['payments/index', 'filtra_pagato' => true]),
])?>
            <?=\hail812\adminlte\widgets\Ribbon::widget([
    'id'       => $smallBox->id . '-ribbon',
    'text'     => 'Pagate',
    'theme'    => 'warning',
    'size'     => 'lg',
    'textSize' => 'lg',
])?>
            <?php \hail812\adminlte\widgets\SmallBox::end()?>
        </div>
        <?php endif?>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?php if ('C004207'<>$cf):?>
        <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
    'title'    => $totsc - $totsc_pagata,
    'text'     => 'Scadenze da Pagare',
    'icon'     => 'far fa-calendar',
    'theme'    => 'Info',
    'linkText' => 'Apri',
    'linkUrl'  => Url::to(['payments/index', 'filtra_pagato' => false]),
])?>

            <?=\hail812\adminlte\widgets\Ribbon::widget([
    'id'       => $smallBox->id . '-ribbon',
    'text'     => 'Non Pagate',
    'theme'    => 'warning',
    'size'     => 'lg',
    'textSize' => 'sm',
])?>
            <?php \hail812\adminlte\widgets\SmallBox::end()?>
            <?php endif?>
        </div>
    </div>
    <div class="row" >
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <div class="card card-succes">
    <div class="card-header">
    <table style="border-collapse: collapse; width: 100%;" border="0"><colgroup><col style="width: 50%;"><col style="width: 50%;"></colgroup>
 <tbody>
 <tr>
 <?php if ('C004207'<>$cf):?>
 <td style="width: 80%;"><h3 class="card-title">Top Articoli </h3>
  </td>
  <?php else :?>
    <td style="width: 80%;"><h3 class="card-title"><a href="https://dashboard.vivenda.it/index.php?r=book">Biblioteca</a> </h3>
  </td>
 
    <?php endif?>
  <?php
$ris = ['level' => null, 'cd_cli' => null, 'id' => null];
if (!Yii::$app->user->isGuest) {
    $usrid = Yii::$app->user->Id;
    $ris   = user::find()
        ->select(['level', 'cd_cli', 'id'])
        ->where(['id' => $usrid])
        ->asArray()
        ->one() ?: ['level' => null, 'cd_cli' => null, 'id' => null];
}

?>
<?php if ('C004207'<>$cf):?>
 <?php if ('C001443' != $ris['cd_cli'] && 'C000065' != $ris['cd_cli']) : ?>
    <td style="width: 20%;">  <h3 class="card-title">Qtà con Um</h3>
 <?php else: ?>
    <td style="width: 20%;">  <h3 class="card-title">Pubblicazioni</h3>

 <?php endif;?>
 
<?php endif?>   
</td>

 </tr>
 </tbody>
 </table>
   <?php
$usrid = Yii::$app->user->Id;
$ris   = user::find()
    ->select(['level', 'cd_cli', 'id', 'ischief'])
    ->where(['id' => $usrid])
    ->asArray()
    ->one() ?: ['level' => null, 'cd_cli' => null, 'id' => null, 'ischief' => null];
if (!Yii::$app->user->isGuest) {
    if ('C001443' != $ris['cd_cli'] && 'C000065' != $ris['cd_cli']) {
        $command2 = $connection->createCommand("select top 5
doc_rows.cd_art,doc_rows.descrizione,sum(doc_rows.qta) as t,um
 from doc_rows
where cd_cli=:id and cd_art is not null
and cd_art in
 (select  cd_ar from  adb_vivendasrl.dbo.ar where cd_argruppo1 is not null)
group by cd_art,descrizione,um
order by sum(qta) desc ")
            ->bindParam(':id', $ris['cd_cli']);
        $resultart = $command2->queryAll();
//yii::error($resultart);
    } else {
        $command2 = $connection->createCommand("select top 5
    doc_rows.cd_art,doc_rows.descrizione,count(doc_rows.cd_art) as t,um
     from doc_rows
    where cd_cli=:id and cd_art is not null
    and cd_art in
     (select  cd_ar from  adb_vivendasrl.dbo.ar where cd_argruppo1 is not null)
     and cd_doc<>'OVC'
    group by cd_art,descrizione,um
    order by count(cd_art) desc ")
            ->bindParam(':id', $ris['cd_cli']);
        $resultart = $command2->queryAll();

    }
}
?>



    <div class="card-tools">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <!-- <span class="badge badge-primary">Articoli</span>-->
    </div>
    <!-- /.card-tools -->
  </div>
  <!-- /.card-header -->

 <?php
if (!Yii::$app->user->isGuest) {
if ($cf<>'C004207'){
    foreach ($resultart as $value) {
        if ('C001443' != $ris['cd_cli'] && 'C000065' != $ris['cd_cli']) {
            echo '<div class="card-body">' .
            '<table style="border-collapse: collapse; width: 100%;" border="0"><colgroup><col style="width: 50%;"><col style="width: 50%;"></colgroup>
 <tbody>
 <tr>
 <td style="width: 80%;">' . $value['descrizione'] . '</td>
 <td style="width: 20%;">' . number_format($value['t'], 0) . ' ' . $value['um'] . '</td>
 </tr>
 </tbody>
 </table>' .
                '</div>';
        } else {

            echo '<div class="card-body">' .
            '<table style="border-collapse: collapse; width: 100%;" border="0">
<colgroup><col style="width: 50%;"><col style="width: 50%;"></colgroup>
<tbody >
<tr>
<td  style="width: 80%;">' . $value['descrizione'] . '</td>
<td style="width: 20%;">' . number_format($value['t'], 0) . '</td>
</tr>
</tbody>
</table>' .
                '</div>';

        }
    }
}
else{
 echo'
 <table> <tbody >
<tr>
<td style="width: 30%;"></td>
<td style="width: 60%;">
 
<a href="https://dashboard.vivenda.it/index.php?r=book">    <i class="nav-icon fas fa-book large-icon"></i></a>
     
 </td>
<td style="width: 20%;"></td>
</tbody>
</table>';
}}
?>
      </div>
            </div>
  <!-- /.card-body -->
  <div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <div class="card card-succes">
    <div class="card-header">
    <h3 class="card-title">Documenti</h3>
  <?php /*$series = [
[
'name' => 'Entity 1',
'data' => [
['2018-10-04', 4.66],
['2018-10-05', 5.0],
],
],
[
'name' => 'Entity 2',
'data' => [
['2018-10-04', 3.88],
['2018-10-05', 3.77],
],
],
[
'name' => 'Entity 3',
'data' => [
['2018-10-04', 4.40],
['2018-10-05', 5.0],
],
],
[
'name' => 'Entity 4',
'data' => [
['2018-10-04', 4.5],
['2018-10-05', 4.18],
],
],
];

echo \onmotion\apexcharts\ApexchartsWidget::widget([
'type' => 'bar', // default area
'height' => '400', // default 350
'width' => '500', // default 100%
'chartOptions' => [
'chart' => [
'toolbar' => [
'show' => true,
'autoSelected' => 'zoom',
],
],
'xaxis' => [
'type' => 'datetime',
// 'categories' => $categories,
],
'plotOptions' => [
'bar' => [
'horizontal' => false,
'endingShape' => 'rounded',
],
],
'dataLabels' => [
'enabled' => false,
],
'stroke' => [
'show' => true,
'colors' => ['transparent'],
],
'legend' => [
'verticalAlign' => 'bottom',
'horizontalAlign' => 'left',
],
],
'series' => $series,
]);

 */
//$pie=['Confermato'=>5,'In attesa'=>2,'Rifutato'=>8];

if ('C000065' != $cf) {
    $command3 = $connection->createCommand("select count(*) as tot
 from doc_head
where cd_cli=:id and confermato=1 ")
        ->bindParam(':id', $ris['cd_cli']);
    $resulconf = $command3->queryAll();
    $command4  = $connection->createCommand("select count(*) as tot
 from doc_head
where cd_cli=:id and (confermato is null or confermato=0)  ")
        ->bindParam(':id', $ris['cd_cli']);
    $resulwait = $command4->queryAll();
    $command5  = $connection->createCommand("select count(*) as tot
 from doc_head
where cd_cli=:id and rifiutato=1 ")
        ->bindParam(':id', $ris['cd_cli']);
    $resulcanc = $command5->queryAll();

    $command6 = $connection->createCommand("select count(*) as tot from (
select distinct  (xid_testa)
 from doc_rows
where cd_cli=:id and f_row is not null
) as t")
        ->bindParam(':id', $ris['cd_cli']);
    $resuleva = $command6->queryAll();
} else {
//$query = Doc_head::find()
//        ->where(['cd_cli'=>$cf])
//        ->andWhere(['<>','cd_doc','OVC'])
//        ->orWhere(['altcli'=>$cf]);

    $command3 = $connection->createCommand("select count(*) as tot
        from doc_head
       where cd_cli=:id and confermato=1 and cd_doc<>'OVC' ")
        ->bindParam(':id', $ris['cd_cli']);
    $resulconf = $command3->queryAll();
    $command4  = $connection->createCommand("select count(*) as tot
        from doc_head
       where cd_cli=:id and (confermato is null or confermato=0)  and cd_doc<>'OVC' ")
        ->bindParam(':id', $ris['cd_cli']);
    $resulwait = $command4->queryAll();
    $command5  = $connection->createCommand("select count(*) as tot
        from doc_head
       where cd_cli=:id and rifiutato=1  and cd_doc<>'OVC'")
        ->bindParam(':id', $ris['cd_cli']);
    $resulcanc = $command5->queryAll();

    $command6 = $connection->createCommand("select count(*) as tot from (
       select distinct  (xid_testa)
        from doc_rows
       where cd_cli=:id and f_row is not null and cd_doc<>'OVC'
       ) as t")
        ->bindParam(':id', $ris['cd_cli']);
    $resuleva = $command6->queryAll();
}

$pie = [];
/*$pie[]=array('Confermati'=>intval($resulconf[0]['tot']));
$pie[]=array('In attesa'=>intval($resulwait[0]['tot']));
$pie[]=array('Rifiutati'=>intval($resulcanc[0]['tot']));
$pie[]=array('Evasi'=>intval($resuleva[0]['tot']));
 */

//$pie[]='pagate'=>500;

$pie[] = intval($resulwait[0]['tot']);
$pie[] = intval($resulconf[0]['tot']);
$pie[] = intval($resuleva[0]['tot']);

$pie[] = intval($resulcanc[0]['tot']);

$conf = $resulconf[0]['tot'];

//$pie=[$conf,6,7,8,9];
//yii::warning($pie);

//yii::warning($resulconf);
//yii::warning($resulwait);
//yii::warning($resulcanc);
//yii::warning($resuleva);

echo \onmotion\apexcharts\ApexchartsWidget::widget([
    'type'   => 'pie', // default area
    //'height' => '400', // default 350
    // 'width' => '500', // default 100%

    'chartOptions' => [
        'labels' => ['In attesa', 'Confermato', 'Evaso', 'Rifiutato'],
        'chart'  => [
            'toolbar' => [
                'show'         => true,
                'autoSelected' => 'zoom',
            ],

        ],

    ],
    'series' => $pie,

]);

?>
</div>

            </div>
            </div>

  <!-- /.card-footer -->

   
<?php
/*
$series= [
'data'=> [
[  'x'=> strtotime('2018-02-12'),
'y'=> 76
],[
'x'=> strtotime('2018-02-12') ,
'y'=> 76
]
],
'xaxis'=>[
'type'=> 'datetime'
],
];*/

//C004207
if ($cf<>'C004207'){
    echo '<div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <div class="card card-succes">
<div class="card-header"> 
    <h3 class="card-title">Scadenze</h3>';
echo \onmotion\apexcharts\ApexchartsWidget::widget([
    'type'   => 'bar', // default area
    //'height' => '400', // default 350
    //'width' => '500', // default 100%
    'chartOptions' => [
        'chart'       => [
            'toolbar' => [
                'show'         => true,
                'autoSelected' => 'zoom',
            ],
        ],
        'xaxis'       => [
            //'type' => 'datetime',
            // 'categories' => $categories,
            'categories' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set'
                , 'Ott', 'Nov', 'Dic'],

        ],
        'plotOptions' => [
            'bar' => [
                'horizontal'  => false,
                'endingShape' => 'rounded',
            ],
        ],
        'dataLabels'  => [
            'enabled' => false,
        ],
        'stroke'      => [
            'show'   => true,
            'colors' => ['transparent'],
        ],
        'legend'      => [
            'verticalAlign'   => 'bottom',
            'horizontalAlign' => 'left',
        ],
    ],
    'series' => $series,
]);
}
?>


</div>
      </div>
            </div> <?php
yii::error($ris['ischief']);
if (($ris['ischief'] ?? 0) == 1) {
    $tmpid = 2;
    Modal::begin([
        //'header'=>'<h4>Clienti</h4>',
        'id'   => 'cli' . $tmpid,
        'size' => 'modal-lg', //classe bootstrap
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    $this->registerJs("
  $('#modalcli_$tmpid').click(function (){
  $('#cli$tmpid').modal('show')
  .find('#modalContent')
  .load($(this).attr('value'));
  });"
    );
    $url = Url::to(['cf', 'id' => Yii::$app->user->identity->id,
//   'mod'->$model
    ]);

    echo Html::button('Cambia Ditta (' . $ris['cd_cli'] . ')', ['value' => $url,
        'class'                                                             => 'btn btn-warning', 'id' => 'modalcli_' . $tmpid]);
    // echo'</td><td width="30%">';
}
?>
    </div>

</div>
