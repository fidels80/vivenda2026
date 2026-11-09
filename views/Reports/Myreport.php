<?php
namespace app\views\reports;
 use app\vendor\koolreport\yii2\Friendship;
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\yii2\Friendship;
    // By adding above statement, you have claim the friendship between two frameworks
    // As a result, this report will be able to accessed all databases of Yii2
    // There are no need to define the settings() function anymore
    // while you can do so if you have other datasources rather than those
    // defined in Laravel.

    public function setup()
    {
        $this->src("sqlserver")
            ->query("SELECT cd_doc,data,numdoc,cd_cli,confermato 
            FROM doc_head")
            ->pipe($this->dataStore("offices"));
    }
}
