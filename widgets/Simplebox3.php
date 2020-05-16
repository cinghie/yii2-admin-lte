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

use yii\bootstrap\Widget;

/**
 * Class Simplebox3
 */
class Simplebox3 extends Widget
{
    /**
     * @var string
     */
    public $bgclass;

    /**
     * @var string
     */
    public $class;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $link;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $subtitle;

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        if ($this->bgclass === null) {
            $this->bgclass = 'bg-aqua';
        }

        if ($this->class === null) {
            $this->class = 'col-md-3 col-sm-6 col-xs-12';
        }

        if ($this->description === null) {
            $this->description = 'More info';
        }

        if ($this->icon === null) {
            $this->icon = 'fa fa-shopping-cart';
        }

        if ($this->link === null) {
            $this->link = '#';
        }

        if ($this->title === null) {
            $this->title = '150';
        }

        if ($this->subtitle === null) {
            $this->subtitle = 'New Orders';
        }

        parent::init();
    }

	/**
	 * @return string
	 */
	public function run()
    {
        return '<div class="'.$this->class.'">
            <div class="small-box '.$this->bgclass.'">
                <div class="inner">
                    <h3>'.$this->title.'</h3>
                    <p>'.$this->subtitle.'</p>
                </div>
                <div class="icon">
                    <i class="'.$this->icon.'"></i>
                </div>
                <a class="small-box-footer" href="'.$this->link.'">
                    '.$this->description.' <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>';
    }
}
