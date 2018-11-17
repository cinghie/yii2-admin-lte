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

class Footer extends Widget
{
    public $copyright_date_start;
    public $copyright_date_end;
    public $copyright_link;
	public $copyright_text;
	public $version;

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        parent::init();

        if ($this->copyright_date_start === null) {
            $this->copyright_date_start = '2014';
        }

        if ($this->copyright_date_end === null) {
            $this->copyright_date_end = date('Y');
        }

        if ($this->copyright_link === null) {
            $this->copyright_link = 'http://www.almsaeedstudio.com';
        }

        if ($this->copyright_text === null) {
            $this->copyright_text = 'Almsaeed Studio';
        }
		
        if ($this->version === null) {
            $this->version = '2.3.1';
        }
    }

	/**
	 * @return string
	 */
	public function run()
    {
        return '<footer class="main-footer">
                    <div class="pull-right hidden-xs">
                      <b>Version</b> '.Html::encode($this->version).'
                    </div>
                    <strong>Copyright &copy; '.Html::encode($this->copyright_date_start).'-'.Html::encode($this->copyright_date_end).' <a href="'.Html::encode($this->copyright_link).'" target="_blank">'.Html::encode($this->copyright_text).'</a>.</strong> All rights reserved.
                </footer>';
    }
}
