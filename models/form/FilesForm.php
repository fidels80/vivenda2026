<?php
namespace app\models\form;

use app\models\Agenda;
use app\models\AgendaFiles;
use Yii;
use yii\base\Model;
use yii\widgets\ActiveForm;

class FilesForm extends Model
{
    private $_Agenda;
    private $_AgendaFiles;


    public function rules()
    {
        return [
            [['Agenda'], 'required'],
            [['AgendaFiles'], 'safe'],
        ];
    }

    public function afterValidate()
    {
        if (!Model::validateMultiple($this->getAllModels())) {
            $this->addError(null); // add an empty error to prevent saving
        }
        parent::afterValidate();
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $transaction = Yii::$app->db->beginTransaction();
        if (!$this->Agenda->save()) {
            $transaction->rollBack();
            return false;
        }
        if (!$this->saveFiles()) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
        return true;
    }
    public function saveFiles() 
    {
        $keep = [];
        foreach ($this->Files as $File) {
            $File->id_agenda = $this->Agenda->id;
            if (!$File->save(false)) {
                return false;
            }
            $keep[] = $File->id;
        }
        $query = AgendaFiles::find()->andWhere(['id_agenda' => $this->Agenda->id]);
        if ($keep) {
            $query->andWhere(['not in', 'id', $keep]);
        }
        foreach ($query->all() as $File) {
            $File->delete();
        }        
        return true;
    }
    public function getAgenda()
    {
         //yii::warning('sto dentro getagenda');
        return $this->_Agenda;
    }
    public function setAgenda($Agenda)
    {
       // yii::warning('sto dentro setagenda');
        if ($Agenda instanceof Agenda) {
            $this->_Agenda = $Agenda;
        } else if (is_array($Agenda)) {
            $this->_Agenda->setAttributes($Agenda);
        }
    }
    public function getFiles()
    {
        if ($this->_AgendaFiles === null) {
            $this->_AgendaFiles = $this->Agenda->isNewRecord ? [] : $this->Agenda->filesall;
        }
 //      yii::warning($this->_AgendaFiles);
        return $this->_AgendaFiles;
    }
    private    function getFile($key=null)
    {
        
        $File = $key && strpos($key, 'new') === false ? AgendaFiles::findOne($key) : false;
        if (!$File) {
            $File = new AgendaFiles();
            $File->loadDefaultValues();
        }
        return $File;
    }

    public function setFiles($Files)
    {
        unset($Files['__id__']); // remove the hidden "new Parcel" row
        $this->_AgendaFiles = [];
        foreach ($Files as $key => $File) {
            if (is_array($File)) {
                $this->_AgendaFiles[$key] = $this->getFile($key);
             yii::warning($key);
                $this->_AgendaFiles[$key]->setAttributes($File);
            } elseif ($File instanceof AgendaFiles) {
                $this->_AgendaFiles[$File->id] = $File;
            }
        }
    }
    public function errorSummary($form)
    {
        $errorLists = [];
        foreach ($this->getAllModels() as $id => $model) {
            $errorList = $form->errorSummary($model, [
              'header' => '<p>Please fix the following errors for <b>' . $id . '</b></p>',
            ]);
            $errorList = str_replace('<li></li>', '', $errorList); // remove the empty error
            $errorLists[] = $errorList;
        }
        return implode('', $errorLists);
    }

    private function getAllModels()
    {
        $models = [
            'Agenda' => $this->Agenda,
        ];
        foreach ($this->Files as $id => $File) {
            $models['File.' . $id] = $this->Files[$id];
        }
        return $models;
    }
}
