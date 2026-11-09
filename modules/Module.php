<?php

namespace app\modules\autoupdate;
use yii;
/**
 * Autoupdate module definition class
 */
class Module extends \yii\base\Module
{
    private $_assetsUrl;
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\autoupdate\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->layout = 'main';

        // custom initialization code goes here
    }

    public function setAssetsUrl($value)

{

$this->_assetsUrl=$value;

}


public function registerCss($file, $media='all')

{

$href = $this->getAssetsUrl().'/css/'.$file;

return '<link rel="stylesheet" type="text/css" href="'.$href.'" media="'.$media.'" />';

}

public function registerImage($file)

{

return $this->getAssetsUrl().'/images/'.$file;

}

public function getAssetsUrl()

{

if($this->_assetsUrl===null)

$this->_assetsUrl=str_replace('web','',Yii::$app->request->baseUrl).'modules/autoupdate';
//'/autoupdate/modules/autoupdate'; //Yii::$app->request->baseUrl;//Yii::$app->getAssetManager()->publish(Yii::getPathOfAlias('module.assets'));

return $this->_assetsUrl;

}
}
