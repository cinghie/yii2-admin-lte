<?php

namespace cinghie\adminlte;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * FullCalendar assets bundled with AdminLTE 2.
 */
class CalendarAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/';

    public $css = [
        'bower_components/fullcalendar/dist/fullcalendar.min.css',
    ];

    public $js = [
        'bower_components/jquery-ui/jquery-ui.min.js',
        'bower_components/moment/moment.js',
        'bower_components/fullcalendar/dist/fullcalendar.min.js',
        'bower_components/fullcalendar/dist/locale-all.js',
    ];

    public $depends = [
        YiiAsset::class,
    ];
}
