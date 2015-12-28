<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-admin-lte
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-AdminLTE
 * @version 1.3.7
 */

namespace cinghie\adminlte\widgets;

use yii\bootstrap\Widget;
use yii\helpers\Html;

class NavbarButton extends Widget
{
    public $icon;
    public $option;
    public $target;
    public $url;

    public function init()
    {
        parent::init();

        if ($this->icon === null) {
            $this->icon = 'fa fa-external-link';
        }

        if ($this->option === null) {
            $this->option = [];
        }

        if ($this->target === null) {
            $this->target = '';
        } else {
            $this->target = ' target="'.$this->target.'"';
        }

        if ($this->url === null) {
            $this->url = 'https://www.google.com';
        }
    }

    public function run()
    {
        return '<li>'.Html::a('<i class="'.Html::encode($this->icon).'"></i>', Html::encode($this->url), $this->option).'</li>';
    }
}
