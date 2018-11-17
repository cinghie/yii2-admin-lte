<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-admin-lte
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-AdminLTE
 * @version 1.5.4
 */

namespace cinghie\adminlte\widgets;

use yii\bootstrap\Widget;
use yii\helpers\Html;

class NavbarButton extends Widget
{
    public $title;
    public $option;
    public $target;
    public $url;

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        parent::init();

        if ($this->title === null) {
            $this->title = '<i class="fa fa-external-link"></i>';
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

	/**
	 * @return string
	 */
	public function run()
    {
        return '<li>'.Html::a($this->title, Html::encode($this->url), $this->option).'</li>';
    }
}
