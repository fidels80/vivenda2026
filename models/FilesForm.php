<?php 
namespace app\model\form;

use app\models\Agenda;
use app\models\Agenda_Files;
use yii;
use yii\base\model;
use yii\widget\ActiveForm;

class FileForm extends model {

    private $_agenda;
    private $_agenda_files;


public function rules(){


    return [
        [['Agenda'],'required'],
        [['Agenda_Files'],'safe'],
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
    if (!$this->saveParcels()) {
        $transaction->rollBack();
        return false;
    }
    $transaction->commit();
    return true;
}



public function saveFIles()
{
    $keep=[];
    foreach($this->Agenda_Files as $file){
        $file->id_Agenda= $this->agenda->id;
        if (!$file->save(false)) {
            return false;
        }
        $keep[] = $file->id;

    }
    $query = Agenda_Files::find()->andWhere(['id_agenda' => $this->product->id]);
    if ($keep) {
        $query->andWhere(['not in', 'id', $keep]);
    }
    foreach ($query->all() as $ag) {
        $ag->delete();
    }        
    return true;

}


public function  getAgenda(){

    return $this->agenda;
}

public function setAgenda($agenda){

if($agenda instanceof Agenda){
    $this->_agenda=$agenda;
}elseif (is_array($agenda)) {
    $this->_agenda->setAttributes($agenda);
}

}
public function getFiles(){
    if($this->_agenda_files===null){
        $this->_agenda_files=$this->_agenda->isNewRecord ? []: $this->_agenda->_agenda_files;
    }
return $this->_agenda_files;
}
public function getFile($key){
    $file=$key && strpos($key,'new')=== false ? Agenda_Files::findOne($key) :false;
    if (!$file){

        $filen= new Agenda_Files();
        $file->loadDefaultValues();
    }
    return $file;


}




public function setFiles($files){
    unset($files['__id__']);
    $this->_agenda_files=[];
    foreach ($files as $key => $file) {
        # code...
        if(is_array($file)){
            $this->_agenda_files[$key]=$this->getAgenda($key);
            $this->_agenda_files[$key]->setAttributes($file);
        }elseif ($file instanceof Agenda_Files){
            $this->_agenda_files[$file->id]=$file;
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
        'Agenda' => $this->agenda,
    ];
    foreach ($this->files as $id => $file) {
        $models['Files.' . $id] = $this->files[$id];
    }
    return $models;
}
}
