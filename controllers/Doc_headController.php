<?php
namespace app\controllers;
use app\models\Doc_head;
use app\models\Doc_headSearch;
use app\models\Doc_rows;
use app\models\Elemail;
use app\models\Model;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * Doc_headController implements the CRUD actions for Doc_head model.
 */
class Doc_headController extends Controller
{
    use AccessDeniedTrait;
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
     * Lists all Doc_head models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->getuser();
        return $this->render('index', [
            'doctipo'=>'all'
        ]);
    }

    /**
     * Displays a single Doc_head model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->getuser();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Creates a new Doc_head model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function odl_actionCreate()
    {
        $this->getuser();
        $model = new Doc_head();
        if ($model->load(Yii::$app->request->post())) {
            $t = Yii::$app->runAction('log/set', ['data' => $model,
                'op' => $model->className() . '-->' . $this->action->id]);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Doc_head model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->getuser();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $t = Yii::$app->runAction('log/set', ['data' => $model,
                'op' => $model->className() . '-->' . $this->action->id]);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionConferma($id)
    {
        $this->getuser();
        $model = $this->findModel($id);
        $model->setAttribute('confermato', 1);
        $t = Yii::$app->runAction('log/set', ['data' => $model,
            'op' => $model->className() . '-->' . $this->action->id]);
        $model->save();
        $query2 = yii::$app->db2
            ->createCommand()
            ->update('DOTES', ['xconfermato' => 1, 'xannullato' => 0, 'cd_cf' => $model->cd_cli, 'xdashcli' => $model->altcli]
                , ['id_dotes' => $model->xid_testa]);
        $query2->execute();
        $usrid = Yii::$app->user->Id;
        if ($usrid !== null) {
            $ris = (new \yii\db\Query())
                ->select(['email', 'cd_cli'])
                ->from('user')
                ->where(['id' => $usrid])
                ->one();
        }
        $cc = (new \yii\db\Query())
            ->select(['ccemail'])
            ->from('ana_cli')
            ->where(['cd_cli' => $ris['cd_cli']])
            ->one();
        $rcc = isset($cc['ccemail']) ? explode(';',$cc['ccemail']) : '';
        $subject = 'Documento Confermato';
        $body = 'Documento Confermato  ' . $model->numdoc . 'del ' . $model->data
        . ' per il cliente ' . $model->cd_cli . PHP_EOL;
       $message = Yii::$app->mailer->compose()
            ->setto($ris['email'])
            ->setFrom(yii::$app->params['supportEmail'])
            ->setReplyTo([yii::$app->params['supportEmail']])
            ->setSubject($subject)
            ->setTextBody($body);
        $rcc = isset($cc['ccemail']) ? $message->setCC(explode(';',$cc['ccemail'])) : '';
        $message->send();
        $message2 = Yii::$app->mailer->compose()
            ->setTo(yii::$app->params['adminEmail'])
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo($ris['email'])
            ->setSubject($subject)
            ->setTextBody($body . 'da parte dell\'utente ' . $ris['email']);
        $rcc = isset($cc['ccemail']) ? $message->setCC(explode(';',$cc['ccemail'])) : '';
        $message2->send();
        $elemail = new Elemail();
        $elemail->setAttribute('nome', $ris['email']);
        $elemail->setAttribute('email', $ris['email']);
        $elemail->setAttribute('Soggetto', $subject);
        $elemail->setAttribute('Corpo', $body);
        $elemail->setAttribute('allegati', $model->id);
        $elemail->save(false);
        return $this->redirect(['view', 'id' => $model->id]);
    }
    public function actionRifiuta($id, $rifiutato_nota = null)
    {
        $this->getuser();
        $model = $this->findModel($id);
        $model->setAttribute('rifiutato', 1);
        $model->setAttribute('rifiutato_nota', $rifiutato_nota);
        $t = Yii::$app->runAction('log/set', ['data' => $model,
            'op' => $model->className() . '-->' . $this->action->id]);
        $model->save();
        return $this->redirect(['view', 'id' => $model->id]);
    }
    /**
     * Deletes an existing Doc_head model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->getuser();
        $t = Yii::$app->runAction('log/set', ['data' => $model,
            'op' => $model->className() . '-->' . $this->action->id]);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    /**
     * Finds the Doc_head model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Doc_head the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $this->getuser();
        if (($model = Doc_head::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionNrifiuta($id = null)
    {
        $this->getuser();
        if (($model = Doc_head::findOne($id)) !== null) {
            if ($model->load(Yii::$app->request->post())) {
                $model->setAttribute('rifiutato', 1);
                $model->setAttribute('rifiutato_nota', $model->rifiutato_nota);
                if (strlen($model->rifiutato_nota) == 0) {
                    return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                }
                $t = Yii::$app->runAction('log/set', ['data' => $model,
                    'op' => $model->className() . '-->' . $this->action->id]);
                $model->save();
                $query2 = yii::$app->db2
                    ->createCommand()
                    ->update('DOTES', ['NotePiede' => $model->rifiutato_nota, 'xannullato' => 1]
                        , ['id_dotes' => $model->xid_testa]);
                $query2->execute();
                $query3 = yii::$app->db2
                    ->createCommand()
                    ->update('DOrig', ['qtaevadibile' => 0]
                        , ['id_dotes' => $model->xid_testa]);
                $query3->execute();
                $usrid = Yii::$app->user->Id;
                if ($usrid !== null) {
                    $ris = (new \yii\db\Query())
                        ->select(['email','cd_cli'])
                        ->from('user')
                        ->where(['id' => $usrid])
                        ->one();
                    //->AsArray();
                }
                $cc = (new \yii\db\Query())
                    ->select(['ccemail'])
                    ->from('ana_cli')
                    ->where(['cd_cli' => $ris['cd_cli']])
                    ->one();
                $rcc = isset($cc['ccemail']) ? $cc['ccemail'] : '';
                $subject = 'Documento Rifiutato';
                $body = 'Documento Rifiutato  ' . $model->numdoc . 'del ' . $model->data
                . ' per il cliente ' . $model->cd_cli . PHP_EOL . 'Motivazione: ' . $model->rifiutato_nota;
                $message = Yii::$app->mailer->compose()
                    ->setto($ris['email'])
                    ->setFrom(yii::$app->params['supportEmail'])
                    ->setReplyTo([yii::$app->params['supportEmail']])
                    ->setSubject($subject)
                    ->setTextBody($body);
                $rcc = isset($cc['ccemail']) ? $message->setCC(explode(';',$cc['ccemail'])) : '';
                $message->send();
                $message2 = Yii::$app->mailer->compose()
                    ->setTo(yii::$app->params['adminEmail'])
                    ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                    ->setReplyTo($ris['email'])
                    ->setSubject($subject)
                    ->setTextBody($body . 'da parte dell\'utente ' . $ris['email']);
                $message2->send();
                $elemail = new Elemail();
                $elemail->setAttribute('nome', $ris['email']);
                $elemail->setAttribute('email', $ris['email']);
                $elemail->setAttribute('Soggetto', $subject);
                $elemail->setAttribute('Corpo', $body);
                $elemail->setAttribute('allegati', $model->id);
                $elemail->save(false);
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }
        }
        return $this->renderAjax('noterif', ['id' => $id, 'model' => $model]);
    }
    public function actionSede($id)
    {
        $this->getuser();
        if (($model = Doc_head::findOne($id)) !== null) {
            if ($model->load(Yii::$app->request->post())) {
                $model->setAttribute('altcli', $model->altcli);
                $alcli = $model->altcli;
                $cf = $model->cd_cli;
                yii::error($model->altcli);
                $t = Yii::$app->runAction('log/set', ['data' => $model,
                    'op' => $model->className() . '-->' . $this->action->id]);
                $model->save();
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }
        }
        return $this->renderAjax('sede', ['id' => $id, 'model' => $model]);
    }
   public function actionNannota($id)
    {
        $this->getuser();
        if (($model = Doc_head::findOne($id)) !== null) {
            if ($model->load(Yii::$app->request->post())) {
                $model->setAttribute('altcli', $model->altcli);
                $alcli = $model->altcli;
                $cf = $model->cd_cli;
                yii::error($model->altcli);
                $t = Yii::$app->runAction('log/set', ['data' => $model,
                    'op' => $model->className() . '-->' . $this->action->id]);
                $xid = $model->xid_testa;
                $xnota = $model->xnota;
                $query2 = yii::$app->db2
                    ->createCommand("
update dotes set xnotedash=:znota where id_dotes=:xid "
                    )->bindValues([':znota' => $xnota, ':xid' => $xid]);
                $query2->execute();
                $chk = $model->dest ?? '0';
                if ($chk != 0) {
                    $ints = yii::$app->db2
                        ->createCommand('select top 1 dotes.cd_cf,dotes.Cd_CF,dotes.Cd_CFSede,dotes.Cd_CFDest,
                        dotes.numerodoc,1,CFSede.Descrizione,CFSede.EMail as sdMail,
                        CFContatto.email as cfcemail,cfcontatto.emailpec
                        from dotes
                        left join CFSede on CFSede.Cd_Cf=dotes.Cd_CF and CFSede.Cd_CFSede=dotes.Cd_CFSede
                        left join CFContatto on CFContatto.Cd_CF=dotes.Cd_CF and CFContatto.Cd_CFDest=dotes.Cd_CFDest
                        where dotes.id_dotes=:id_Dotes
                        ')->bindValues([':id_Dotes' => $model->xid_testa]);
                    $intesta = $ints->queryAll();
                }
                 $usrid = Yii::$app->user->Id;
                if ($usrid !== null) {
                    $ris = (new \yii\db\Query())
                        ->select(['cd_cli'])
                        ->from('user')
                        ->where(['id' => $usrid])
                        ->one();
                    //->AsArray();
                }
                if (isset($intesta)) {
                    $cc = (new \yii\db\Query())
                        ->select(['ccemail'])
                        ->from('ana_cli')
                        ->where(['cd_cli' => $ris['cd_cli']])
                        ->one();
                    $rcc = isset($cc['ccemail']) ? $cc['ccemail'] : '';
                    $subject = 'Effettuata Modifica/aggiunta alla nota del docummento '
                    . $model->numdoc . 'del ' . $model->data;
                    $body = 'Testo nota :' . PHP_EOL . $xnota;
                    $message = Yii::$app->mailer->compose()
                        ->setto($intesta[0]['cfcemail'] ?? $intesta[0]['sdMail'])
                        ->setFrom(yii::$app->params['supportEmail'])
                        ->setReplyTo([yii::$app->params['supportEmail']])
                        ->setSubject($subject)
                        ->setTextBody($body);
                    $rcc = isset($cc['ccemail']) ? $message->setCC(explode(';',$cc['ccemail'])) : '';
                    $message->send();
                    $message2 = Yii::$app->mailer->compose()
                        ->setTo(yii::$app->params['adminEmail'])
                        ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                        ->setReplyTo($intesta[0]['cfcemail'] ?? $intesta[0]['sdMail'])
                        ->setSubject($subject)
                        ->setTextBody($body . PHP_EOL . 'da parte dell\'utente '
                            . $intesta[0]['cfcemail'] ?? $intesta[0]['sdMail']);
                    $message2->send();
                }

               $model->save();
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

            }
        }
        return $this->renderAjax('nota', ['id' => $id, 'model' => $model]);
    }
    public function getuser()
    {
        $usrid = Yii::$app->user->Id;
        if ($usrid !== null) {
            $ris = (new \yii\db\Query())
                ->select(['level', 'cd_cli', 'moduli'])
                ->from('user')
                ->where(['id' => $usrid])
                ->one();
            $nmod = (str_replace('app\controllers', '', str_replace('Controller', '', __CLASS__)));
            $nmod = (str_replace('\\', '', $nmod));
            $nmod = strtoupper($nmod);
            $mn = (new \yii\db\Query())
                ->select(['voce', 'url', 'Nmodulo'])
                ->from('xmenu')
                ->where(['upper(Nmodulo)' => strtoupper($nmod)])
                ->one();
        }
        $arrmod = unserialize($ris['moduli'] ?? '');
        $go = 0;
        if (($ris['level'] ?? 0) != 100) {
            if (is_array($arrmod)) {
                foreach ($arrmod as $value) {
                    if (strtoupper($value) == strtoupper(($mn['voce'] ?? 'default value'))) {
                        $go = 1;
                    }
                    if ($nmod == 'DOC_HEAD' || strtoupper($value) == 'ELENCO') {
                        $go = 1;
                    }
                }
            }
        } else {
            $go = 1;
        }
        if (Yii::$app->user->isGuest || $ris['level'] == null) {
            $messaggio =
                "<h1>Attenzione</h1>\n\n"
                . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";
            $this->denyAccess();
        }
        if ($go == 0) {
            $messaggio =
                "<h1>Attenzione</h1>\n\n"
                . "<p><strong>NON SEI AUTORIZZATO AD ACCEDERE!!!.</strong></p>\n";
            $this->denyAccess();
        }
    }

    public function actionCreate()
    {
        $this->getuser();
        $modelHead = new Doc_head();
        $modelsRow = [new Doc_Rows];
        if ($modelHead->load(Yii::$app->request->post())) {
            $modelsRow = Model::createMultiple(Doc_Rows::classname());
            Model::loadMultiple($modelsRow, Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsRow),
                    ActiveForm::validate($modelHead)
                );
            }
            $mdoc = yii::$app->db
                ->createCommand('select max(numdoc) as m from doc_head
where cd_doc=:PRV
                        ')->bindValues([':PRV' => $modelHead->cd_doc]);
            $mdoc_r = $mdoc->queryAll();
            $modelHead->numdoc = strval($mdoc_r[0]['m'] + 1);
            if (1 == 1) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelHead->save()) {
                        foreach ($modelsRow as $modelsRow_one) {
                            $modelsRow_one->doc_head_id = $modelHead->id;
                            $modelsRow_one->cd_doc = $modelHead->cd_doc;
                            $modelsRow_one->data = $modelHead->data;
                            $modelsRow_one->cd_cli = $modelHead->cd_cli;
                            $modelsRow_one->numdoc = $modelHead->numdoc;
                            $modelsRow_one->iva = rtrim(ltrim($modelsRow_one->iva));
                            if (!($flag = $modelsRow_one->save())) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('create', [
            'model' => $modelHead,
            'items' => $modelsRow,
        ]);
    }
    public function actionDupd($id)
    {
     /*
        $model = $this->findModel($id);
        $items2 = Doc_rows::find()->where(['doc_head_id' => $id])
        ->orderBy(['nriga'=>SORT_ASC])
        ->all(); //$model->items;
        if ($model->load(Yii::$app->request->post())) {
            $oldIDs = ArrayHelper::map($items2, 'id', 'id');
            $items2 = Model::createMultiple(Doc_rows::classname(), $items);
            Model::loadMultiple($items2, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($items2, 'id', 'id')));
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($items2),
                    ActiveForm::validate($model)
                );
            }
            $valid = $model->validate();
            if ($valid) {
                $amount = 0;
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            Doc_rows::deleteAll(['id' => $deletedIDs]);
                        }
                        $i=1;
                        foreach ($items2 as $m) {
                            $m->doc_head_id = $model->id;
                            $tRis = (new \yii\db\Query())
                                ->select(['newid() as id'])
                                ->from('doc_rows')
                                ->one();
                            $m->id ? '' : $m->id = $tRis['id'];
                            empty($m->nriga) ? $m->nriga=$i : $m->nriga;
                            $i=$i+1;
                            if (!($flag = $m->save(false))) {
                                $transaction->rollBack();
                                break;
                            } else {
                            }
                        }
                        $model->save(false);
                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'documento registrato con successo');
                        return $this->redirect(['index']);
                    }
                } catch (\Exception$e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'errore! rollback!' . $e);
                    return $e;
                }
            } else {
                Yii::$app->session->setFlash('error', 'Uups! qualcosa non ha funzionato!');
            }
        }
        return $this->render('create', [
            'model' => $model,
            'items2' => (empty($items2)) ? [new Doc_rows()] : $items2,
            //'items3'=>$this->getrows($model->id)
        ]);*/
      
         $model = $this->findModel($id);
      $items2 = Doc_rows::find()->where(['doc_head_id' => $id])->orderBy(['nriga'=>SORT_ASC]);
       


    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        $transaction = Yii::$app->db->beginTransaction();
         // return var_dump($_POST['Doc_head'] ['docRows']);
        try {
            // Rimozione dei record eliminati dall'utente
            $oldIds = ArrayHelper::getColumn($model->docRows, 'id');
            $newIds = array_filter($_POST['Doc_head'] ['docRows'] ?? [],
              function ($item) {
                return isset($item['id']);
            });
            $toDeleteIds = array_diff($oldIds, $newIds);
            if (!empty($toDeleteIds)) {
                Doc_rows::deleteAll(['id' => $toDeleteIds]);
            }
            $i=1;
            // Aggiornamento o creazione dei record modificati o nuovi
            foreach ($_POST['Doc_head'] ['docRows'] as $item) {
                if (!empty($item['id'])) {
                    $docRow = Doc_rows::findOne($item['id']);
                    $docRow->attributes = $item;
                        $docRow->setAttribute('nriga',$i);
                    $docRow->save();
                } else {
                    $docRow = new Doc_rows();
                    $docRow->attributes = $item;
                   $docRow->setAttribute('nriga',$i);
                    $docRow->doc_head_id = $model->id;
                    $docRow->save();
                }
                $i=$i+1;
            }
            
            $model->save();
            $transaction->commit();
            return $this->redirect(['view', 'id' => $model->id]);
            
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    return $this->render('create', [
        'model' => $model,
        'items2' => (empty($items2)) ? [new Doc_rows()] : $items2,
    ]);

    }
    public function actionDdelete($id)
    {
        $modelHead = $this->findModelHead($id);
        $modelsRows = $modelHead->docRows;

        foreach ($modelsRows as $modelRow) {
            $modelRow->delete();
        }
        $modelHead->delete();
        Yii::$app->session->setFlash('success', 'Document deleted successfully.');
        return $this->redirect(['index']);
    }

    public function actionGetrows($id){
$artdett=Doc_rows::find()
 ->where(['doc_head_id'=>$id])
->all();
\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//$out = ['result'=>['']];
// $out['results'] = array_values($artdett);





 


return $artdett;

}
public function afterFind() {
    parent::afterFind();
    $this->schedule = \yii\helpers\Json::decode($this->schedule);
} 

/*
$cc = (new \yii\db\Query())
->select(['ccemail'])
->from('ana_cli')
->where(['cd_cli' => $ris['cd_cli']])
->one();

$rcc = isset($cc['ccemail']) ? $cc['ccemail'] : '';
$rcc = isset($cc['ccemail']) ? $message->setCC($cc['ccemail']) : '';

 */


 public function actionPreventivo()
 {
     $this->getuser();
     return $this->render('index', [
         'doctipo'=>'prv'
     ]);
 }
 public function actionXordini()
 {
     $this->getuser();
     return $this->render('index', [
         'doctipo'=>'ord'
     ]);
 }
 public function actionFatture()
 {
     $this->getuser();
     return $this->render('index', [
         'doctipo'=>'ftv'
     ]);
 }

    /**
     * Endpoint server-side per DataTables (elenco documenti).
     */
    public function actionData()
    {
        $this->getuser();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $params = $request->get();

        $baseQuery = $this->buildDocHeadBaseQuery($params);
        $recordsTotal = (int) $baseQuery->count();

        $query = clone $baseQuery;
        $this->applyDocHeadFilters($query, $params);
        $recordsFiltered = (int) $query->count();

        $this->applyDocHeadOrder($query, $params);

        $start = (int) ($params['start'] ?? 0);
        $length = (int) ($params['length'] ?? 20);
        if ($length < 1) {
            $length = 20;
        }

        $rows = $query->offset($start)->limit($length)->all();

        $data = [];
        $totImponibile = 0.0;
        $totImposta = 0.0;
        foreach ($rows as $model) {
            $row = $this->docHeadRowData($model);
            $totImponibile += (float) $row['imponibile'];
            $totImposta += (float) $row['imposta'];
            $data[] = $row;
        }

        return [
            'draw' => (int) ($params['draw'] ?? 1),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'totals' => [
                'imponibile' => $totImponibile,
                'imposta' => $totImposta,
            ],
        ];
    }

    /**
     * Endpoint per il dettaglio espandibile di una riga (renderAjax di _expand-row).
     */
    public function actionExpand($id)
    {
        $this->getuser();
        return $this->renderAjax('_expand-row', ['model' => $this->findModel($id)]);
    }

    /**
     * Export completo (server-side) dei dati filtrati in formato Excel (HTML).
     */
    public function actionExport()
    {
        $this->getuser();
        $request = Yii::$app->request;
        $params = $request->get();

        $query = $this->buildDocHeadBaseQuery($params);
        $this->applyDocHeadFilters($query, $params);
        $this->applyDocHeadOrder($query, $params);

        $rows = $query->all();

        $html = '<html><head><meta charset="utf-8"></head><body>';
        $html .= '<table border="1">';
        $html .= '<tr>';
        foreach (['Tipo Doc.', 'Num.Doc.', 'Data Doc.', 'Intestatario', 'Richiedente', 'Confermato', 'Rifiutato', 'Note', 'Imponibile', 'Imposta'] as $h) {
            $html .= '<th>' . htmlspecialchars($h) . '</th>';
        }
        $html .= '</tr>';

        foreach ($rows as $model) {
            $r = $this->docHeadRowData($model);
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars((string) $r['cd_doc']) . '</td>';
            $html .= '<td>' . htmlspecialchars((string) $r['numdoc']) . '</td>';
            $html .= '<td>' . htmlspecialchars((string) $r['data']) . '</td>';
            $html .= '<td>' . htmlspecialchars((string) $r['cd_cli']) . '</td>';
            $html .= '<td>' . htmlspecialchars((string) $r['dest']) . '</td>';
            $html .= '<td>' . ($r['confermato'] ? 'SI' : 'No') . '</td>';
            $html .= '<td>' . ($r['rifiutato'] ? 'SI' : 'No') . '</td>';
            $html .= '<td>' . htmlspecialchars((string) $r['note']) . '</td>';
            $html .= '<td>' . number_format((float) $r['imponibile'], 2, ',', '.') . '</td>';
            $html .= '<td>' . number_format((float) $r['imposta'], 2, ',', '.') . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table></body></html>';

        $filename = 'documenti_' . date('Ymd_His') . '.xls';
        Yii::$app->response->headers->set('Content-Type', 'application/vnd.ms-excel');
        Yii::$app->response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        Yii::$app->response->format = Response::FORMAT_RAW;
        return $html;
    }

    private function buildDocHeadBaseQuery($params)
    {
        $query = Doc_head::find();

        $level = Yii::$app->user->identity->level ?? 100;
        $cf = Yii::$app->user->identity->cd_cli ?? null;

        if ($level != 100) {
            if ($cf == 'C000065') {
                $query->andWhere(['cd_cli' => $cf])->andWhere(['<>', 'cd_doc', 'OVC']);
                $query->orWhere(['altcli' => $cf]);
            } else {
                $query->andWhere(['or', ['cd_cli' => $cf], ['altcli' => $cf]]);
            }
        }

        $doctipo = $params['doctipo'] ?? 'all';
        switch ($doctipo) {
            case 'prv':
                $query->andWhere(['cd_doc' => 'PRA']);
                break;
            case 'ord':
                $query->andWhere(['cd_doc' => 'OVA']);
                break;
            case 'ftv':
                $query->andWhere(['cd_doc' => ['FAF', 'FTE', 'FTR', 'FTV', 'RFC', 'RFX']]);
                break;
        }

        return $query;
    }

    private function applyDocHeadFilters(&$query, $params)
    {
        $fc = $params['filtra_confermato'] ?? null;
        if ($fc !== null && $fc !== '') {
            $query->andWhere(['confermato' => $fc]);
        }
        $fr = $params['filtra_rifiutato'] ?? null;
        if ($fr !== null && $fr !== '') {
            $query->andWhere(['rifiutato' => $fr]);
        }

        foreach (['cd_doc', 'numdoc', 'cd_cli', 'dest'] as $f) {
            if (!empty($params[$f])) {
                $query->andWhere(['like', $f, $params[$f]]);
            }
        }

        if (!empty($params['confermato'])) {
            $query->andWhere(['confermato' => $params['confermato']]);
        }
        if (!empty($params['rifiutato'])) {
            $query->andWhere(['rifiutato' => $params['rifiutato']]);
        }

        $from = $this->normalizeDate($params['data_from'] ?? null);
        $to = $this->normalizeDate($params['data_to'] ?? null);
        if ($from && $to) {
            $query->andWhere(['between', 'data', $from, $to]);
        } elseif ($from) {
            $query->andWhere(['>=', 'data', $from]);
        } elseif ($to) {
            $query->andWhere(['<=', 'data', $to]);
        }

        $s = $params['search'] ?? '';
        $searchValue = is_array($s) ? trim($s['value'] ?? '') : trim((string) $s);
        if ($searchValue !== '') {
            $query->andWhere(['or',
                ['like', 'cd_doc', $searchValue],
                ['like', 'numdoc', $searchValue],
                ['like', 'cd_cli', $searchValue],
                ['like', 'note', $searchValue],
            ]);
        }
    }

    private function applyDocHeadOrder(&$query, $params)
    {
        $sortableMap = [
            1 => 'cd_doc',
            2 => 'numdoc',
            3 => 'data',
            4 => 'cd_cli',
            5 => 'dest',
            6 => 'confermato',
            7 => 'rifiutato',
            8 => 'note',
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
        $query->addOrderBy(['xid_testa' => SORT_DESC]);
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

    private function docHeadRowData($model)
    {
        $intestatario = null;
        $ris2 = \app\models\anacli::find()->where(['cd_cli' => $model->cd_cli])->one();
        if ($ris2) {
            $intestatario = $ris2->Desk;
        }

        $richiedente = '';
        $chk = $model->dest ?? '0';
        if ($chk != 0) {
            $richiedente = $this->richiedenteEmail($model->xid_testa);
        }

        $imponibile = 0.0;
        $imposta = 0.0;
        $tot = (new \yii\db\Query())
            ->select(['TotImponibilee', 'totimpostae'])
            ->from('DOTotali')
            ->where(['Id_DoTes' => $model->xid_testa])
            ->one(Yii::$app->db2);
        if ($tot) {
            $imponibile = (float) ($tot['TotImponibilee'] ?? 0);
            $imposta = (float) ($tot['totimpostae'] ?? 0);
        }

        return [
            'DT_RowId' => $model->id,
            'id' => $model->id,
            'xid_testa' => $model->xid_testa,
            'cd_doc' => $model->cd_doc,
            'numdoc' => $model->numdoc,
            'data' => $model->data ? date('d/m/Y', strtotime($model->data)) : '',
            'cd_cli' => $intestatario,
            'cd_cli_code' => $model->cd_cli,
            'dest' => $richiedente,
            'confermato' => (int) ($model->confermato ?? 0),
            'rifiutato' => (int) ($model->rifiutato ?? 0),
            'note' => $model->note,
            'imponibile' => $imponibile,
            'imposta' => $imposta,
        ];
    }

    private function richiedenteEmail($xidTesta)
    {
        if (!$xidTesta) {
            return '';
        }
        try {
            $ints = Yii::$app->db2
                ->createCommand('select top 1 dotes.cd_cf,dotes.Cd_CF,dotes.Cd_CFSede,dotes.Cd_CFDest,
                    dotes.numerodoc,1,CFSede.Descrizione,CFSede.EMail as sdMail,
                    CFContatto.email as cfcemail,cfcontatto.emailpec
                    from dotes
                    left join CFSede on CFSede.Cd_Cf=dotes.Cd_CF and CFSede.Cd_CFSede=dotes.Cd_CFSede
                    left join CFContatto on CFContatto.Cd_CF=dotes.Cd_CF and CFContatto.Cd_CFDest=dotes.Cd_CFDest
                    where dotes.id_dotes=:id_Dotes')
                ->bindValues([':id_Dotes' => $xidTesta]);
            $intesta = $ints->queryAll();
            if (!isset($intesta[0])) {
                return '';
            }
            $richiedente = (new \yii\db\Query())
                ->select(['email'])
                ->from('user')
                ->where(['email' => $intesta[0]['sdMail']])
                ->orWhere(['email' => $intesta[0]['cfcemail']])
                ->orWhere(['email' => $intesta[0]['emailpec']])
                ->one();
            return $richiedente['email'] ?? '';
        } catch (\Exception $e) {
            return '';
        }
    }
}