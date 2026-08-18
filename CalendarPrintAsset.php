<?php

namespace cinghie\adminlte;

use yii\web\AssetBundle;

/**
 * FullCalendar print stylesheet bundled with AdminLTE 2.
 */
class CalendarPrintAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/';

    public $css = [
        'bower_components/fullcalendar/dist/fullcalendar.print.min.css',
    ];

    public $cssOptions = [
        'media' => 'print',
    ];

    public $depends = [
        CalendarAsset::class,
    ];
}
