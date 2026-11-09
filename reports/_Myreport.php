<?php
namespace app\reports;
use yii;
 use \koolreport\yii2\Friendship;
 use \koolreport\processes\Sort;

class _MyReport extends \koolreport\KoolReport
{
    use \koolreport\yii2\Friendship;
    // By adding above statement, you have claim the friendship between two frameworks
    // As a result, this report will be able to accessed all databases of Yii2
    // There are no need to define the settings() function anymore
    // while you can do so if you have other datasources rather than those
    // defined in Laravel.

    public function setup()
    {
        
       // $cf = Yii::$app->user->identity->cd_cli;

        
        $this->src("sqlserver")
            ->query("select id
      ,xid_testa
      ,cd_cli
      ,Cd_PG
      ,DataScadenza
      ,DataPagamento
      ,DataFattura
      ,NumFattura
      ,Protocollo
      ,Pagata
      ,NumEffetto
      ,TotEffetti
      ,ImportoV
      ,IncassoV from payments where cd_cli=:cd_Cli")
      ->params(array(
            ":cd_Cli"=>$this->params["cd_Cli"] ))
                  ->pipe(new Sort(array(
            "Cd_PG"=>"asc",
            "DataScadenza"=>"desc"
        )))
            ->pipe($this->dataStore("offices"));
    }
}
