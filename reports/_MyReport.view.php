<?php
use \koolreport\yii2\Friendship;
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\koolphp\Card;

?>
<html>
    <head>
    <title>My Report</title>
    </head>
    <body>
        <h1>It works</h1>
        <?php


Card::create(array(
    "value" => 1233,
    "title" => "Month Sale",
));

echo '<br><br><br><br><br>';



Table::create([
    "dataSource" => $this->dataStore("offices"),
     "options"=>array(
            "order"=>array(
                array(1,"asc")
            )
            ),
    "paging"=>array(
        "pageSize"=>100,
        "pageIndex"=>0,
    ),
],);
?>
    </body>
</html>
 