<?php

namespace app\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Response;

/**
 * SottocommessaController: elenco completo delle sottocommesse (DOSottoCommessa)
 * con filtri per data, cliente e descrizione.
 */
class SottocommessaController extends Controller
{
    use AccessDeniedTrait;

    public function actionIndex()
    {
        $this->getuser();
        return $this->render('index');
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

        $data = [];
        foreach ($rows as $r) {
            $data[] = [
                'Cd_DOSottoCommessa' => $r['Cd_DOSottoCommessa'],
                'Descrizione' => $r['Descrizione'],
                'Cd_CF' => $r['Cd_CF'],
                'DescrizioneCF' => $r['DescrizioneCF'],
                'DataInizio' => $this->formatDate($r['DataInizio']),
                'DataFineReale' => $this->formatDate($r['DataFineReale']),
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
     * Endpoint select2: clienti da cf con codice che inizia per "C" (db2).
     */
    public function actionClienti($q = '')
    {
        $this->getuser();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $q = trim((string) $q);
        $query = (new Query())
            ->select(['Cd_CF', 'Descrizione'])
            ->from('cf')
            ->where(['like', 'Cd_CF', 'C%', false]);
        if ($q !== '') {
            $query->andWhere(['or',
                ['like', 'Cd_CF', $q],
                ['like', 'Descrizione', $q],
            ]);
        }
        $query->orderBy(['Cd_CF' => SORT_ASC])->limit(50);
        $rows = $query->all(Yii::$app->db2);
        $results = [];
        foreach ($rows as $r) {
            $results[] = [
                'id' => trim((string) $r['Cd_CF']),
                'text' => trim((string) $r['Cd_CF']) . ' - ' . trim((string) $r['Descrizione']),
            ];
        }
        return ['results' => $results];
    }

    /**
     * Endpoint tooltip: numero righe DORig e dettaglio (max 5) della sottocommessa.
     */
    public function actionRighe($cd)
    {
        $this->getuser();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cd = trim((string) $cd);
        if ($cd === '') {
            return ['count' => 0, 'righe' => []];
        }
        $count = (new Query())
            ->from('DORig')
            ->where(['Cd_DOSottoCommessa' => $cd])
            ->count('*', Yii::$app->db2);
        $rows = (new Query())
            ->select(['x_cm', 'xdatainizio', 'xdatafine'])
            ->from('DORig')
            ->where(['Cd_DOSottoCommessa' => $cd])
            ->orderBy(['xdatainizio' => SORT_DESC])
            ->limit(5)
            ->all(Yii::$app->db2);
        $righe = [];
        foreach ($rows as $r) {
            $righe[] = [
                'x_cm' => $r['x_cm'],
                'xdatainizio' => $this->formatDate($r['xdatainizio']),
                'xdatafine' => $this->formatDate($r['xdatafine']),
            ];
        }
        return ['count' => $count, 'righe' => $righe];
    }

    private function buildQuery()
    {
        return (new Query())
            ->select([
                's.Cd_DOSottoCommessa',
                's.Descrizione',
                's.Cd_CF',
                'c.Descrizione AS DescrizioneCF',
                's.DataInizio',
                's.DataFineReale',
            ])
            ->from('DOSottoCommessa s')
            ->leftJoin('cf c', 'c.Cd_CF = s.Cd_CF');
    }

    private function applyFilters(Query &$query, $params)
    {
        if (!empty($params['Descrizione'])) {
            $query->andWhere(['like', 's.Descrizione', $params['Descrizione']]);
        }
        if (!empty($params['Cliente'])) {
            $query->andWhere(['or',
                ['like', 's.Cd_CF', $params['Cliente']],
                ['like', 'c.Descrizione', $params['Cliente']],
            ]);
        }
        $from = $this->normalizeDate($params['DataInizioFrom'] ?? null);
        $to = $this->normalizeDate($params['DataInizioTo'] ?? null);
        if ($from && $to) {
            $query->andWhere(['between', 's.DataInizio', $from, $to]);
        } elseif ($from) {
            $query->andWhere(['>=', 's.DataInizio', $from]);
        } elseif ($to) {
            $query->andWhere(['<=', 's.DataInizio', $to]);
        }

        $fineFrom = $this->normalizeDate($params['DataFineFrom'] ?? null);
        $fineTo = $this->normalizeDate($params['DataFineTo'] ?? null);
        if ($fineFrom && $fineTo) {
            $query->andWhere(['between', 's.DataFineReale', $fineFrom, $fineTo]);
        } elseif ($fineFrom) {
            $query->andWhere(['>=', 's.DataFineReale', $fineFrom]);
        } elseif ($fineTo) {
            $query->andWhere(['<=', 's.DataFineReale', $fineTo]);
        }

        $s = $params['search'] ?? '';
        $searchValue = is_array($s) ? trim($s['value'] ?? '') : trim((string) $s);
        if ($searchValue !== '') {
            $query->andWhere(['or',
                ['like', 's.Cd_DOSottoCommessa', $searchValue],
                ['like', 's.Descrizione', $searchValue],
                ['like', 's.Cd_CF', $searchValue],
                ['like', 'c.Descrizione', $searchValue],
            ]);
        }
    }

    private function applyOrder(Query &$query, $params)
    {
        $sortableMap = [
            0 => 's.Cd_DOSottoCommessa',
            1 => 's.Descrizione',
            2 => 's.Cd_CF',
            3 => 'c.Descrizione',
            4 => 's.DataInizio',
            5 => 's.DataFineReale',
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
        $query->addOrderBy(['s.DataInizio' => SORT_DESC]);
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
