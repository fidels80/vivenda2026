<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\xmenu;
use app\models\User;
use app\models\Xsubmenu;
//use kartik\sidenav\SideNav;
use app\modules\warehouse\models\whprop;
use app\modules\warehouse\models\whitems;
use app\modules\warehouse\models\whstores;

use yii\helpers\ArrayHelper;
AppAsset::register($this);


?>


<div class="Warehouse-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the vjjiew content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>



        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>



<table class="table table-striped">
<tr>
<td>a</td>
<td>b</td>
<td>c</td>
<td>d</td>
<td>e</td>
</tr>
<tr>
<td>f</td>
<td>g</td>
<td>h</td>
<td>i</td>
<td>l</td>
</tr>
</table>

</div>
