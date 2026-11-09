<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Asset bundle per centralizzare DataTables e le sue estensioni (Bootstrap 4).
 * Utilizza i plugin distribuiti con AdminLTE 3 per garantire versioni coerenti.
 */
class DataTablesAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';

    public $css = [
        'datatables-bs4/css/dataTables.bootstrap4.min.css',
        'datatables-buttons/css/buttons.bootstrap4.min.css',
        'datatables-fixedheader/css/fixedHeader.bootstrap4.min.css',
        'datatables-responsive/css/responsive.bootstrap4.min.css',
    ];

    public $js = [
        'datatables/jquery.dataTables.min.js',
        'datatables-bs4/js/dataTables.bootstrap4.min.js',
        'datatables-buttons/js/dataTables.buttons.min.js',
        'datatables-buttons/js/buttons.bootstrap4.min.js',
        'jszip/jszip.min.js',
        'pdfmake/pdfmake.min.js',
        'pdfmake/vfs_fonts.js',
        'datatables-buttons/js/buttons.html5.min.js',
        'datatables-buttons/js/buttons.print.min.js',
        'datatables-fixedheader/js/dataTables.fixedHeader.min.js',
        'datatables-fixedheader/js/fixedHeader.bootstrap4.min.js',
        'datatables-responsive/js/dataTables.responsive.min.js',
        'datatables-responsive/js/responsive.bootstrap4.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\FontAwesomeAsset',
    ];

    public $jsOptions = [
        'position' => View::POS_END,
    ];
}
