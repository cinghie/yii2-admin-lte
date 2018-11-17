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
use yii\widgets\Breadcrumbs;

class ContentHeader extends Widget
{
    public $breadcrumbs;
    public $title;
    public $subtitle;

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        if ($this->title === null) {
            $this->title = 'Dashboard';
        }

        if ($this->subtitle === null) {
            $this->subtitle = '<small>Version 2.0</small>';
        } elseif ($this->subtitle !== '') {
            $this->subtitle = '<small>'.Html::encode($this->subtitle).'</small>';
        }

        if ($this->breadcrumbs === null) {
            $this->breadcrumbs = '<ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Dashboard</li>
            </ol>';
        } elseif ($this->breadcrumbs === []) {
            $this->breadcrumbs = '<ol class="breadcrumb">
                <li><pre>SET $this[params]->breadcrumbs</pre></li>
            </ol>';
        } else {
            $this->breadcrumbs = Breadcrumbs::widget([
                'links' => $this->breadcrumbs,
            ]);
        }
    }

	/**
	 * @return string
	 */
	public function run()
    {
        return '<section class="content-header">
                    <h1>'.Html::encode($this->title).$this->subtitle.'</h1>'.$this->breadcrumbs.
               '</section>';
    }

}
