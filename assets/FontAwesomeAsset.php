<?php

namespace app\assets;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $basePath = '@webroot/fontawesome';
    public $baseUrl = '@web/fontawesome';

    public $css = [
        'css/all.min.css',
    ];
}
