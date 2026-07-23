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
use yii\helpers\Html;

/**
 * Class Simplebox1
 */
class Simplebox1 extends Widget
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
    public $icon;

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

        if ($this->icon === null) {
            $this->icon = 'fa fa-envelope-o';
        }

        if ($this->title === null) {
            $this->title = 'Messages';
        }

        if ($this->subtitle === null) {
            $this->subtitle = '1,410';
        }

        parent::init();
    }

	/**
	 * @return string
	 */
	public function run()
    {
        return '<div class="' . Html::encode($this->class) . '">
            <div class="info-box">
                <span class="info-box-icon ' . Html::encode($this->bgclass) . '">
                    <i class="' . Html::encode($this->icon) . '"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">' . Html::encode($this->title) . '</span>
                    <span class="info-box-number">' . Html::encode($this->subtitle) . '</span>
                </div>
            </div>
        </div>';
    }
}
