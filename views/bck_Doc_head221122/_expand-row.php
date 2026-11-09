 
<?php

echo '<table id="product-parcels" class="table table-condensed table-bordered" >';
echo '<thead>';
echo '<tr>';
//echo '<th>id_agenda</th>';
//echo '<th width=50px >Evaso</th>';

//echo '<th>Cod. Art.</th>';
echo '<th>Descrizione</th>';
echo '<th>Data Consegna</th>';
echo '<th>Nr. Gazzetta</th>';
echo '<th>Nr. Inserzione</th>';

echo '<th>U.M.</th>';

echo '<th>Qta</th>';
echo '<th>Prezzo</th>';
//echo '<th>note</th>';
echo '<th>Al. Iva</th>';
echo '<th>File</th>';

echo '</tr>';
echo '</thead>';
echo '<tbody>';

//yii::warning(var_dump($model->getrowssall()));

foreach ($model->rowsall as $value) {
    echo '<tr >';

// echo  '<td>';

//echo  $value['cd_art'];

//  echo '</td>';
echo '<td>';
echo $value['descrizione'];
echo '</td>';
echo '<td>';
echo $value['datacons'];
echo '</td>';
echo '<td>';
echo $value['nrgazzetta'];
echo '</td>';
echo '<td>';
echo $value['nrinserzione'];
echo '</td>';

echo '<td>';
echo $value['um'];
echo '</td>';
echo '<td>';
echo number_format($value['qta'], 2);

//  echo  Html::a('scarica',['agenda/genfile','id' => $value['id'],'file'=>str_replace(' ', '_',$value['nome_file']) ]);
echo '</td>';
echo '<td>';
echo number_format($value['prezzo'], 2);
echo '</td>';
echo '<td>';
echo $value['iva'];
echo '</td>';
echo '<td>';
echo '</tr>';


}
echo '<tr id="product-new-parcel-block" style="display: none;">';
echo '</tr>';
echo '</tbody>';
echo '</table>';

?>


<?php
//   echo '<table id="product-parcels" class="table table-condensed table-bordered">';
//  echo '<thead>';
//  echo '<tr>';
//  //echo '<th>id_agenda</th>';
//  echo '<th>cdFile_art</th>';
echo '<table id="product-files" class="table table-condensed table-bordered">';
echo '<thead>';
echo '<tr>';
//echo '<th>id_agenda</th>';
echo '<th>file</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
foreach ($model->filesall as $value) {
    // echo '<tr>';
    
    if ($value['entita'] == 'DOTES') {
        echo '<tr>';
        echo '<td>';
        echo $value['nomefile'];
        echo '</td>';
          echo '</tr>';
    }

}
echo '<tr id="files-new-parcel-block" style="display: none;">';
echo '</tr>';
echo '</tbody>';
echo '</table>';

?>
 