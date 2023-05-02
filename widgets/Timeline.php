<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-admin-lte
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-AdminLTE
 * @version 1.5.5
 */

namespace cinghie\adminlte\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class Timeline extends Widget
{
    /**
     * @inheritdoc
     */
    public function init()
    {

    }

    /**
     * @return string
     */
    public function run()
    {
        $html = '<section class="timeline">';

        $html .= '<div class="row"><div class="col-md-12">';

        $html .= '</div></div>';


        $html .= '<div class="timeline">

<div class="time-label">
<span class="bg-red">10 Feb. 2014</span>
</div>


<div>
<i class="fas fa-envelope bg-blue"></i>
<div class="timeline-item">
<span class="time"><i class="fas fa-clock"></i> 12:05</span>
<h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
<div class="timeline-body">
Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
weebly ning heekya handango imeem plugg dopplr jibjab, movity
jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
quora plaxo ideeli hulu weebly balihoo...
</div>
<div class="timeline-footer">
<a class="btn btn-primary btn-sm">Read more</a>
<a class="btn btn-danger btn-sm">Delete</a>
</div>
</div>
</div>


</div>';

        $html .= '</section">';

        return $html;
    }
}
