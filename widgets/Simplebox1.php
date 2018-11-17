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

class Simplebox1 extends Widget
{
    public $bgclass;
    public $class;
    public $icon;
    public $title;
    public $subtitle;

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        parent::init();

        if ($this->bgclass === null) {
            $this->bgclass = 'bg-aqua';
        }

        if ($this->class === null) {
            $this->class = 'col-md-3 col-sm-6 col-xs-12';
        }

        if ($this->icon === null) {
            $this->icon = 'fa fa-envelope-o';
        }

        if ($this->title === null) {
            $this->title = 'Messages';
        }

        if ($this->subtitle === null) {
            $this->subtitle = '1,410';
        }
    }

	/**
	 * @return string
	 */
	public function run()
    {
        return '<div class="'.$this->class.'">
            <div class="info-box">
                <span class="info-box-icon '.$this->bgclass.'">
                    <i class="'.$this->icon.'"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">'.$this->title.'</span>
                    <span class="info-box-number">'.$this->subtitle.'</span>
                </div>
            </div>
        </div>';
    }
}
