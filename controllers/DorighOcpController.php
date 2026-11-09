<?php

namespace app\controllers;

use app\models\CommessaCover;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * DorighOcpController: righe documento DORig con Cd_DO = 'OCP' (sola lettura).
 */
class DorighOcpController extends Controller
{
    use AccessDeniedTrait;
    public function actionIndex()
    {
        $this->getuser();
        $cd = Yii::$app->request->get('Cd_DOSottoCommessa', '');
        return $this->render('index', ['cd' => $cd]);
    }

    /**
     * Caricamento immagine copertina di una sottocommessa (AJAX, in modale).
     */
    public function actionUploadCover()
    {
        $this->getuser();
        Yii::$app->response->format = Response::FORMAT_JSON;

        $cd = trim((string) Yii::$app->request->post('cd_dosottocommessa', ''));
        if ($cd === '') {
            return ['success' => false, 'message' => 'Codice commessa mancante'];
        }

        $image = UploadedFile::getInstanceByName('image');
        if (!$image) {
            return ['success' => false, 'message' => 'Nessuna immagine selezionata'];
        }

        $dir = Yii::getAlias('@webroot') . '/uploads/commesse';
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                return ['success' => false, 'message' => 'Impossibile creare la cartella di upload'];
            }
        }

        $safe = preg_replace('/[^A-Za-z0-9_-]/', '_', $cd);
        if ($safe === '' || $safe === null) {
            $safe = 'commessa';
        }
        $filename = $safe . '.' . $image->extension;

        foreach (glob($dir . '/' . $safe . '.*') as $old) {
            @unlink($old);
        }

        if (!$image->saveAs($dir . '/' . $filename)) {
            return ['success' => false, 'message' => 'Errore nel salvataggio del file'];
        }

        $path = '/uploads/commesse/' . $filename;

        $model = CommessaCover::findOne(['cd_dosottocommessa' => $cd]);
        if (!$model) {
            $model = new CommessaCover();
            $model->cd_dosottocommessa = $cd;
        }
        $model->image_path = $path;
        if ($model->save(false)) {
            return ['success' => true, 'message' => 'Copertina caricata', 'image_path' => $path];
        }
        return ['success' => false, 'message' => 'Errore nel salvataggio del record'];
    }

    /**
     * Endpoint server-side per DataTables.
     */
    public function actionData()
    {
        $this->getuser();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $params = Yii::$app->request->get();

        $base = $this->buildQuery();
        $recordsTotal = (int) (clone $base)->count('*', Yii::$app->db2);

        $query = $this->buildQuery();
        $this->applyFilters($query, $params);
        $recordsFiltered = (int) (clone $query)->count('*', Yii::$app->db2);

        $this->applyOrder($query, $params);

        $start = (int) ($params['start'] ?? 0);
        $length = (int) ($params['length'] ?? 25);
        if ($length < 1) {
            $length = 25;
        }

        $rows = $query->offset($start)->limit($length)->all(Yii::$app->db2);

        // Documenti presenti per le righe della pagina corrente: l'attach
        // "Foto professionali" va mostrato solo se la riga ha almeno un file.
        $rowsWithDocs = $this->getRowIdsWithDocs(
            array_column($rows, 'Id_DORig'),
            array_column($rows, 'Id_DOTes')
        );

        $data = [];
        foreach ($rows as $r) {
            $hasDocs = isset($rowsWithDocs[(int) $r['Id_DORig']])
                || (!empty($r['Id_DOTes']) && isset($rowsWithDocs[(int) $r['Id_DOTes']]));

            $data[] = [
                'Id_DORig' => $r['Id_DORig'],
                'Cd_DOSottoCommessa' => $r['Cd_DOSottoCommessa'],
                'SottoCommessaDescrizione' => $r['SottoCommessaDescrizione'],
                'Id_DOSottoCommessa' => $r['Id_DOSottoCommessa'],
                'Cd_AR' => $r['Cd_AR'],
                'Descrizione' => $r['Descrizione'],
                'Qta' => $r['Qta'],
                'x_cf' => $r['x_cf'],
                'xdatainizio' => $this->formatDate($r['xdatainizio']),
                'xdatafine' => $this->formatDate($r['xdatafine']),
                'x_cm' => $r['x_cm'],
                'HasDocs' => $hasDocs ? 1 : 0,
            ];
        }

        return [
            'draw' => (int) ($params['draw'] ?? 1),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ];
    }

    /**
     * Elenco documenti collegati nel DMS di Arca per una riga DORig.
     * @param int $id Id_DORig
     */
    public function actionDmsDocs($id)
    {
        $this->getuser();
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = (int) $id;

        // Id_DOTes e Cd_DOSottoCommessa della riga: i file della riga sono
        // quelli collegati direttamente alla DORig oppure alla testata DOTES.
        // I documenti della commessa sono mostrati solo nell'archivio commessa.
        $row = (new Query())
            ->select(['d.Id_DORig', 'd.Id_DOTes', 'd.Cd_DOSottoCommessa'])
            ->from('DORig d')
            ->where(['d.Id_DORig' => $id])
            ->one(Yii::$app->db2);

        $all = [];
        if ($row) {
            // Nella riga vanno tutti i documenti che non sono quelli
            // dell'archivio commessa (EntityTable = DOSOTTOCOMMESSA).
            $all = $this->mergeDmsDocs(
                $this->findDmsDocsByEntity('DORIG', [$row['Id_DORig']]),
                $this->findDmsDocsByEntity('DOTES', [$row['Id_DOTes']])
            );
        }

        foreach ($all as &$doc) {
            $doc['DocumentDate'] = $this->formatDate($doc['DocumentDate']);
        }
        unset($doc);

        return ['data' => $all];
    }

    /**
     * Scarica un documento DMS.
     * @param int $id Id_DmsDocument
     */
    public function actionDmsDownload($id)
    {
        $this->getuser();

        $doc = (new Query())
            ->select(['Id_DmsDocument', 'FileName', 'FileExt', 'Content', 'FilePath', 'LinkedToFS'])
            ->from('DmsDocument')
            ->where(['Id_DmsDocument' => (int) $id])
            ->one(Yii::$app->db2);

        if (!$doc) {
            throw new NotFoundHttpException('Documento non trovato.');
        }

        $fileName = trim((string) $doc['FileName']);
        if ($fileName === '') {
            $fileName = 'documento-' . (int) $doc['Id_DmsDocument'];
        }
        $fileName = basename($fileName);
        $ext = strtolower(ltrim(trim((string) $doc['FileExt']), '.'));
        $mimeType = $ext !== '' ? FileHelper::getMimeTypeByExtension('file.' . $ext) : null;
        if (!$mimeType) {
            $mimeType = 'application/octet-stream';
        }

        // Se il contenuto è nel database lo inviamo direttamente.
        if (!empty($doc['Content'])) {
            return Yii::$app->response->sendContentAsFile($doc['Content'], $fileName, [
                'mimeType' => $mimeType,
                'inline' => false,
            ]);
        }

        // Altrimenti proviamo a leggere il file dal percorso di rete salvato.
        $filePath = trim((string) $doc['FilePath']);
        if ($filePath !== '') {
            $candidates = [
                rtrim($filePath, "\\/") . DIRECTORY_SEPARATOR . $fileName,
                $filePath,
            ];
            foreach ($candidates as $candidate) {
                if (@is_file($candidate)) {
                    return Yii::$app->response->sendFile($candidate, $fileName, [
                        'mimeType' => $mimeType,
                        'inline' => false,
                    ]);
                }
            }
        }

        throw new NotFoundHttpException('Il file non è disponibile: contenuto assente dal database e percorso di rete non accessibile.');
    }

    /**
     * Dati per il grafico di Gantt delle campagne OCP.
     * @param string $cd Codice sottocommessa
     * @param string $Cd_AR Articolo
     * @param string $Descrizione Descrizione riga
     * @param string $x_cf Cliente finale
     */
    public function actionGantt($cd = '', $Cd_DOSottoCommessa = '', $Cd_AR = '', $Descrizione = '', $x_cf = '')
    {
        $this->getuser();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $db = Yii::$app->db2;

        $cd = trim((string) $cd);
        if ($cd === '') {
            $cd = trim((string) $Cd_DOSottoCommessa);
        }
        $Cd_AR = trim((string) $Cd_AR);
        $Descrizione = trim((string) $Descrizione);
        $x_cf = trim((string) $x_cf);

        $commessa = null;
        if ($cd !== '') {
            $commessa = (new Query())
                ->select([
                    's.Cd_DOSottoCommessa',
                    's.Descrizione',
                    's.Cd_DOCommessaStato',
                    'st.Descrizione AS DescrizioneStato',
                    's.DataInizio',
                    's.DataFinePresunta',
                    's.DataFineReale',
                ])
                ->from('DOSottoCommessa s')
                ->leftJoin('DOCommessaStato st', 'st.Cd_DOCommessaStato = s.Cd_DOCommessaStato')
                ->where(['s.Cd_DOSottoCommessa' => $cd])
                ->one($db);
        }

        $query = $this->buildQuery();
        if ($cd !== '') {
            $query->andWhere(['d.Cd_DOSottoCommessa' => $cd]);
        }
        if ($Cd_AR !== '') {
            $query->andWhere(['like', 'd.Cd_AR', $Cd_AR]);
        }
        if ($Descrizione !== '') {
            $query->andWhere(['like', 'd.Descrizione', $Descrizione]);
        }
        if ($x_cf !== '') {
            $query->andWhere(['like', 'd.x_cf', $x_cf]);
        }
        $query->orderBy(['d.xdatainizio' => SORT_ASC, 'd.Id_DORig' => SORT_ASC]);

        $limit = 500;
        $rows = $query->limit($limit + 1)->all($db);
        $truncated = count($rows) > $limit;
        if ($truncated) {
            $rows = array_slice($rows, 0, $limit);
        }

        $commessaStart = $commessa ? $this->toIsoDate($commessa['DataInizio']) : null;
        $commessaEnd = null;
        if ($commessa) {
            $commessaEnd = $this->toIsoDate($commessa['DataFineReale']);
            if (!$commessaEnd) {
                $commessaEnd = $this->toIsoDate($commessa['DataFinePresunta']);
            }
        }

        $items = [];
        $itemStarts = [];
        $itemEnds = [];
        foreach ($rows as $r) {
            $start = $this->toIsoDate($r['xdatainizio']);
            $end = $this->toIsoDate($r['xdatafine']);

            // Le date della riga sono la base del Gantt. Se mancano non
            // inventiamo un intervallo: la riga non viene rappresentata.
            if (!$start || !$end) {
                continue;
            }
            if (strtotime($end) < strtotime($start)) {
                $tmp = $start;
                $start = $end;
                $end = $tmp;
            }

            $itemStarts[] = $start;
            $itemEnds[] = $end;

            $items[] = [
                'Id_DORig' => (int) $r['Id_DORig'],
                'cliente' => trim((string) $r['x_cf']),
                'centro_media' => trim((string) $r['x_cm']),
                'Cd_AR' => trim((string) $r['Cd_AR']),
                'Descrizione' => trim((string) $r['Descrizione']),
                'Cd_DOSottoCommessa' => trim((string) $r['Cd_DOSottoCommessa']),
                'start' => $start,
                'end' => $end,
                'start_label' => $this->formatDate($start),
                'end_label' => $this->formatDate($end),
            ];
        }

        if (empty($items) && !$commessaStart && !$commessaEnd) {
            return [
                'success' => false,
                'message' => 'Nessuna riga con date valide per il Gantt.',
            ];
        }

        $rangeStart = $commessaStart;
        $rangeEnd = $commessaEnd;
        if (!empty($itemStarts)) {
            $minItem = min($itemStarts);
            $maxItem = max($itemEnds);
            if (!$rangeStart || strtotime($minItem) < strtotime($rangeStart)) {
                $rangeStart = $minItem;
            }
            if (!$rangeEnd || strtotime($maxItem) > strtotime($rangeEnd)) {
                $rangeEnd = $maxItem;
            }
        }
        if (!$rangeStart) {
            $rangeStart = !empty($itemStarts) ? min($itemStarts) : $rangeEnd;
        }
        if (!$rangeEnd) {
            $rangeEnd = !empty($itemEnds) ? max($itemEnds) : $rangeStart;
        }
        if (!$rangeStart || !$rangeEnd) {
            return [
                'success' => false,
                'message' => 'Nessuna data valida per il Gantt.',
            ];
        }

        return [
            'success' => true,
            'commessa' => $commessa ? [
                'cd' => trim((string) $commessa['Cd_DOSottoCommessa']),
                'descrizione' => trim((string) $commessa['Descrizione']),
                'stato' => trim((string) ($commessa['DescrizioneStato'] ?: $commessa['Cd_DOCommessaStato'])),
                'start' => $commessaStart,
                'end' => $commessaEnd,
                'end_source' => ($commessa['DataFineReale'] ? 'reale' : 'presunta'),
            ] : null,
            'range' => [
                'start' => $rangeStart,
                'end' => $rangeEnd,
            ],
            'items' => $items,
            'truncated' => $truncated,
            'limit' => $limit,
        ];
    }

    /**
     * Dettaglio commessa e documenti DMS collegati (AJAX).
     * @param string $cd Codice sottocommessa (Cd_DOSottoCommessa)
     */
    public function actionCommessaDetail($cd = '')
    {
        $this->getuser();
        Yii::$app->response->format = Response::FORMAT_JSON;

        $cd = trim((string) $cd);
        if ($cd === '') {
            return ['success' => false, 'message' => 'Codice commessa mancante'];
        }

        // ADB_VIVENDASRL
        $db = Yii::$app->db2;

        $detail = (new Query())
            ->select([
                's.Cd_DOSottoCommessa',
                's.Cd_DOCommessa',
                's.Descrizione',
                's.Cd_CF',
                'c.Descrizione AS DescrizioneCF',
                's.Cd_DOCommessaStato',
                'st.Descrizione AS DescrizioneStato',
                's.DataInizio',
                's.DataFinePresunta',
                's.DataFineReale',
                's.NoteDoSottoCommessa',
            ])
            ->from('DOSottoCommessa s')
            ->leftJoin('cf c', 'c.Cd_CF = s.Cd_CF')
            ->leftJoin('DOCommessaStato st', 'st.Cd_DOCommessaStato = s.Cd_DOCommessaStato')
            ->where(['s.Cd_DOSottoCommessa' => $cd])
            ->one($db);

        if (!$detail) {
            return ['success' => false, 'message' => 'Commessa non trovata'];
        }

        $detail['DataInizio'] = $this->formatDate($detail['DataInizio']);
        $detail['DataFinePresunta'] = $this->formatDate($detail['DataFinePresunta']);
        $detail['DataFineReale'] = $this->formatDate($detail['DataFineReale']);

        // Archivio documenti della commessa: SOLO i documenti collegati
        // direttamente alla sottocommessa (EntityTable = DOSOTTOCOMMESSA).
        // Gli altri documenti restano visibili nelle rispettive righe.
        $docs = $this->findDmsDocsByEntity('DOSOTTOCOMMESSA', [$cd], false);

        foreach ($docs as &$row) {
            $row['DocumentDate'] = $this->formatDate($row['DocumentDate']);
        }
        unset($row);

        $cover = CommessaCover::find()
            ->select('image_path')
            ->where(['cd_dosottocommessa' => $cd])
            ->scalar();

        return [
            'success' => true,
            'detail' => $detail,
            'cover' => $cover ?: null,
            'documents' => $docs,
        ];
    }

    /**
     * Endpoint select2: articoli da ar (db2).
     */
    public function actionArticoli($q = '')
    {
        $this->getuser();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $q = trim((string) $q);
        $query = (new Query())
            ->select(['cd_ar', 'descrizione'])
            ->from('ar');
        if ($q !== '') {
            $query->andWhere(['or',
                ['like', 'cd_ar', $q],
                ['like', 'descrizione', $q],
            ]);
        }
        $query->orderBy(['cd_ar' => SORT_ASC])->limit(50);
        $rows = $query->all(Yii::$app->db2);
        $results = [];
        foreach ($rows as $r) {
            $results[] = [
                'id' => trim((string) $r['cd_ar']),
                'text' => trim((string) $r['cd_ar']) . ' - ' . trim((string) $r['descrizione']),
            ];
        }
        return ['results' => $results];
    }

    /**
     * Endpoint select2: clienti finali distinti (x_cf) da DORig (db2).
     */
    public function actionClientiFinali($q = '')
    {
        $this->getuser();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $q = trim((string) $q);
        $query = (new Query())
            ->select(['x_cf'])
            ->from('DORig')
            ->where(['not', ['x_cf' => null]])
            ->andWhere(['<>', 'x_cf', ''])
            ->distinct();
        if ($q !== '') {
            $query->andWhere(['like', 'x_cf', $q]);
        }
        $query->orderBy(['x_cf' => SORT_ASC])->limit(50);
        $rows = $query->all(Yii::$app->db2);
        $results = [];
        foreach ($rows as $r) {
            $v = trim((string) $r['x_cf']);
            if ($v === '') {
                continue;
            }
            $results[] = ['id' => $v, 'text' => $v];
        }
        return ['results' => $results];
    }

    private function buildQuery()
    {
        return (new Query())
            ->select([
                'd.Id_DORig',
                'd.Id_DOTes',
                'd.Cd_DOSottoCommessa',
                's.Descrizione AS SottoCommessaDescrizione',
                's.Id_DOSottoCommessa',
                'd.Cd_AR',
                'd.Descrizione',
                'd.Qta',
                'd.x_cf',
                'd.xdatainizio',
                'd.xdatafine',
                'd.x_cm',
            ])
            ->from('DORig d')
            ->leftJoin('DOSottoCommessa s', 's.Cd_DOSottoCommessa = d.Cd_DOSottoCommessa')
            ->where(['d.Cd_DO' => 'OCP']);
    }

    private function applyFilters(Query &$query, $params)
    {
        foreach (['Cd_DOSottoCommessa', 'Cd_AR', 'x_cf', 'x_cm'] as $f) {
            if (!empty($params[$f])) {
                $query->andWhere(['like', 'd.' . $f, $params[$f]]);
            }
        }

        if (!empty($params['SottoCommessaDescrizione'])) {
            $query->andWhere(['like', 's.Descrizione', $params['SottoCommessaDescrizione']]);
        }
        if (!empty($params['Descrizione'])) {
            $query->andWhere(['like', 'd.Descrizione', $params['Descrizione']]);
        }

        // Tabs Svolte / Future della card OCP.
        $periodo = trim((string) ($params['periodo'] ?? ''));
        if ($periodo === 'svolte') {
            $query->andWhere(['<=', 'd.xdatafine', new Expression('CAST(GETDATE() AS date)')]);
        } elseif ($periodo === 'future') {
            $query->andWhere(['>', 'd.xdatainizio', new Expression('CAST(GETDATE() AS date)')]);
        }

        $from = $this->normalizeDate($params['xdatainizio_from'] ?? null);
        $to = $this->normalizeDate($params['xdatainizio_to'] ?? null);
        if ($from && $to) {
            $query->andWhere(['between', 'd.xdatainizio', $from, $to]);
        } elseif ($from) {
            $query->andWhere(['>=', 'd.xdatainizio', $from]);
        } elseif ($to) {
            $query->andWhere(['<=', 'd.xdatainizio', $to]);
        }

        $s = $params['search'] ?? '';
        $searchValue = is_array($s) ? trim($s['value'] ?? '') : trim((string) $s);
        if ($searchValue !== '') {
            $query->andWhere(['or',
                ['like', 'd.Cd_DOSottoCommessa', $searchValue],
                ['like', 's.Descrizione', $searchValue],
                ['like', 'd.Cd_AR', $searchValue],
                ['like', 'd.Descrizione', $searchValue],
                ['like', 'd.x_cf', $searchValue],
                ['like', 'd.x_cm', $searchValue],
            ]);
        }
    }

    private function applyOrder(Query &$query, $params)
    {
        $sortableMap = [
            0 => 'd.Cd_DOSottoCommessa',
            1 => 's.Descrizione',
            2 => 'd.Cd_AR',
            3 => 'd.Descrizione',
            4 => 'd.Qta',
            5 => 'd.x_cf',
            6 => 'd.xdatainizio',
            7 => 'd.xdatafine',
            8 => 'd.x_cm',
        ];
        $order = $params['order'] ?? [];
        if (is_array($order) && !empty($order)) {
            foreach ($order as $o) {
                $col = (int) ($o['column'] ?? 0);
                $dir = (strtoupper($o['dir'] ?? 'asc') === 'DESC') ? SORT_DESC : SORT_ASC;
                if (isset($sortableMap[$col])) {
                    $query->addOrderBy([$sortableMap[$col] => $dir]);
                }
            }
        }
        $query->addOrderBy(['d.Id_DORig' => SORT_DESC]);
    }

    /**
     * Restituisce gli Id (DORig o DOTes) che hanno almeno un documento DMS.
     * I documenti della commessa (DOSOTTOCOMMESSA) non contano: quelli sono
     * visibili solo nell'archivio della commessa.
     *
     * @param array $dorigIds
     * @param array $dotesIds
     * @return array Mappa Id => true
     */
    private function getRowIdsWithDocs($dorigIds, $dotesIds)
    {
        $result = [];
        $dorigIds = array_values(array_unique(array_filter(array_map('intval', (array) $dorigIds))));
        $dotesIds = array_values(array_unique(array_filter(array_map('intval', (array) $dotesIds))));

        if (!empty($dorigIds)) {
            $rows = (new Query())
                ->select(['EntityId'])
                ->distinct()
                ->from('DmsDocument')
                ->where(['EntityTable' => 'DORIG', 'EntityId' => $dorigIds])
                ->all(Yii::$app->db2);
            foreach ($rows as $row) {
                $result[(int) $row['EntityId']] = true;
            }
        }

        if (!empty($dotesIds)) {
            $rows = (new Query())
                ->select(['EntityId'])
                ->distinct()
                ->from('DmsDocument')
                ->where(['EntityTable' => 'DOTES', 'EntityId' => $dotesIds])
                ->all(Yii::$app->db2);
            foreach ($rows as $row) {
                $result[(int) $row['EntityId']] = true;
            }
        }

        return $result;
    }

    /**
     * Recupera i documenti DMS collegati a una o più entità.
     *
     * EntityId è una colonna sql_variant: per DORIG/DOTES va confrontata con
     * valori interi, altrimenti SQL Server non trova le righe (il binding di
     * una stringa produce sempre zero risultati).
     *
     * @param string $entityTable Nome entità (DORIG, DOTES, DOSOTTOCOMMESSA)
     * @param array $entityIds Id delle entità
     * @param bool $intKeys True se EntityId è numerico (DORIG/DOTES), false se
     *                       è un codice testuale (DOSOTTOCOMMESSA)
     * @return array
     */
    private function findDmsDocsByEntity($entityTable, $entityIds, $intKeys = true)
    {
        $ids = [];
        foreach ((array) $entityIds as $id) {
            if ($intKeys) {
                $id = (int) $id;
                if ($id > 0) {
                    $ids[$id] = $id;
                }
            } else {
                $id = trim((string) $id);
                if ($id !== '') {
                    $ids[$id] = $id;
                }
            }
        }
        if (empty($ids)) {
            return [];
        }
        $ids = array_values($ids);

        return (new Query())
            ->select(['Id_DmsDocument', 'EntityTable', 'FileName', 'DocumentDate', 'Descrizione', 'NumeroRif'])
            ->from('DmsDocument')
            ->where(['EntityTable' => $entityTable, 'EntityId' => $ids])
            ->all(Yii::$app->db2);
    }

    /**
     * Unisce più elenchi di documenti DMS eliminando i duplicati.
     */
    private function mergeDmsDocs(...$lists)
    {
        $docs = [];
        foreach ($lists as $list) {
            foreach ((array) $list as $doc) {
                $key = (int) $doc['Id_DmsDocument'];
                if (!isset($docs[$key])) {
                    $docs[$key] = $doc;
                }
            }
        }

        $docs = array_values($docs);
        usort($docs, function ($a, $b) {
            $dateA = !empty($a['DocumentDate']) ? strtotime($a['DocumentDate']) : 0;
            $dateB = !empty($b['DocumentDate']) ? strtotime($b['DocumentDate']) : 0;
            if ($dateA === $dateB) {
                return (int) $b['Id_DmsDocument'] <=> (int) $a['Id_DmsDocument'];
            }
            return $dateB <=> $dateA;
        });

        return $docs;
    }

    private function normalizeDate($value)
    {
        if (!$value) {
            return null;
        }
        $value = trim($value);
        $d = \DateTime::createFromFormat('d/m/Y', $value);
        if ($d !== false) {
            return $d->format('Y-m-d');
        }
        $d = \DateTime::createFromFormat('Y-m-d', $value);
        if ($d !== false) {
            return $d->format('Y-m-d');
        }
        return $value;
    }

    private function formatDate($value)
    {
        if (!$value) {
            return '';
        }
        $ts = strtotime($value);
        if ($ts === false) {
            return $value;
        }
        return date('d/m/Y', $ts);
    }

    private function toIsoDate($value)
    {
        if (!$value) {
            return null;
        }
        $ts = strtotime($value);
        if ($ts === false) {
            return null;
        }
        return date('Y-m-d', $ts);
    }

    private function getuser()
    {
        if (Yii::$app->user->isGuest) {
            $this->denyAccess();
        }
        $usrid = Yii::$app->user->Id;
        $ris = (new Query())
            ->select(['level'])
            ->from('user')
            ->where(['id' => $usrid])
            ->one();
        if (!$ris || $ris['level'] === null) {
            $this->denyAccess();
        }
    }
}
