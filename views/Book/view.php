<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->titolo;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$startDate = strtotime('-365 days'); // 365 giorni fa
$endDate = time(); // Oggi

// Genera una data casuale tra $startDate e $endDate
$randomTimestamp = mt_rand($startDate, $endDate);
yii::warning($randomTimestamp);
$randomNumber = mt_rand(1, 100);
$randomNumber2 = mt_rand(1, 100);

// Aggiungi due decimali casuali
$randomNumberWithDecimals = $randomNumber2 + (mt_rand(0, 99) / 100);
// Stili CSS personalizzati per la visualizzazione a schermo intero
$this->registerCss('
    .full-screen-container {
        width: 100%;
        max-width: 600px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        margin: 10px; /* Aggiungiamo margine per separare i blocchi */
    }

    @media (min-width: 768px) {
        .full-screen-container {
            width: calc(33.33% - 20px); /* Calcoliamo la larghezza per fare 3 colonne in una riga */
        }
    }

    .book-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .book-info {
        margin-bottom: 15px;
    }

    .book-info-label {
        font-weight: bold;
    }

    .book-info-value {
        margin-left: 10px;
    }

    .book-actions {
        margin-top: 20px;
    }

    .book-actions .btn {
        margin-right: 10px;
    }
');

?>
<div class="d-flex flex-wrap justify-content-center align-items-start">
    <div class="full-screen-container">
        <div class="book-details">
            <div class="book-title"><?= Html::encode($this->title) ?></div>

            <div class="book-info">
                <span class="book-info-label">ID:</span>
                <span class="book-info-value"><?= Html::encode($model->id) ?></span>
            </div>

            <div class="book-info">
                <span class="book-info-label">Editore:</span>
                <span class="book-info-value"><?= Html::encode($model->editore) ?></span>
            </div>

            <div class="book-info">
                <span class="book-info-label">ISBN/ISSN:</span>
                <span class="book-info-value"><?= Html::encode($model->issn_isbn) ?></span>
            </div>

            <div class="book-info">
                <span class="book-info-label">Formato:</span>
                <span class="book-info-value"><?= Html::encode($model->formato) ?></span>
            </div>

            <div class="book-info">
                <span class="book-info-label">Prezzo:</span>
                <span class="book-info-value"><?= Yii::$app->formatter->asCurrency($model->prezzo) ?></span>
            </div>

            <div class="book-info">
                <span class="book-info-label">Link:</span>
                <span class="book-info-value"><?= Html::a(Html::encode($model->link), $model->link, ['target' => '_blank']) ?></span>
            </div>

            <div class="book-info">
                <span class="book-info-label">Data inizio abbonamento:</span>
                <span class="book-info-value"><?= Yii::$app->formatter->asDate($model->data_inizio) ?></span>
            </div>

            <div class="book-info">
                <span class="book-info-label">Data fine abbonamento:</span>
                <span class="book-info-value"><?= Yii::$app->formatter->asDate($model->datafine) ?></span>
            </div>

            <div class="book-info">
                <span class="book-info-label">Attivo:</span>
                <span class="book-info-value"><?= $model->attivo ? 'Yes' : 'No' ?></span>
            </div>

            <div class="book-actions">
                <?= Html::a('Torna all\'elenco', ['index'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
 
    <div class="full-screen-container">
        <div class="book-details">
            <div class="book-title"><?= Html::encode("Nota") ?></div>

            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque malesuada neque sit amet enim euismod, quis sollicitudin est ultrices. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Pellentesque pretium euismod nisl, vitae tincidunt lorem convallis sed. Donec nulla sapien, lobortis et interdum sed, dapibus sed enim. Donec dignissim, neque id laoreet pellentesque, nibh justo pellentesque ipsum, at elementum nulla turpis non nulla. Nam non nunc tellus. Nullam at augue ac enim tempus ornare eu vitae eros. Nullam ac sem pulvinar, congue sapien id, aliquet sapien. Pellentesque eu justo at est congue scelerisque. Ut vitae velit fermentum, commodo erat ut, efficitur quam. Pellentesque faucibus, magna quis volutpat tincidunt, nibh enim iaculis sapien, vitae tristique enim odio sit amet sapien. Nullam rhoncus ante dui, ac pretium tortor ultricies porttitor. Praesent aliquet orci sit amet erat consectetur eleifend. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;
        </div>
    </div>
    
    <!--<div class="full-screen-container"
    >
        <div class="book-details">
           <div class="book-title"><?php //Html::encode("Ordini") ?></div>
            <div class="book-info">
                <span class="book-info-label">Data Ultimo Ordine</span>
                <span class="book-info-value"><?php //echo  date('d/m/Y', $randomTimestamp); ?></span>
            </div>
            <div class="book-info">
                <span class="book-info-label">Quantità in magazzino</span>
                <span class="book-info-value"><?php  //echo $randomNumber ?></span>
            </div>
            <div class="book-info">
                <span class="book-info-label">Prezzo Medio</span>
                <span class="book-info-value"><?php  //echo $randomNumberWithDecimals ?> €</span>
            </div>
            <div class="book-info">
              <h5> I dati presenti in questa scheda sono a mero scopo dimostrato e non rappresentano la realtà ma quello che potremmo inserire all'interno di questa scheda, cosi come la nota nella scheda di fianco</h5>
            </div>
        </div>
    </div>-->
    <!-- Ripetere il blocco full-screen-container per ogni libro -->
    <!-- Esempio: -->
    <!-- <div class="full-screen-container"> ... </div> -->
</div>
