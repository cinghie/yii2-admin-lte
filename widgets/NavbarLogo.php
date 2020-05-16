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

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;

/**
 * Class NavbarLogo
 */
class NavbarLogo extends Widget
{
    /**
     * @var string
     */
    public $logo_lg;

    /**
     * @var string
     */
    public $logo_mini;

    /**
     * @var string
     */
    public $logo_url;

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        if ($this->logo_lg === null) {
            $this->logo_lg = '<b>Admin</b>LTE';
        }

        if ($this->logo_mini === null) {
            $this->logo_mini = '<b>A</b>LT';
        }

        if ($this->logo_url === null) {
            $this->logo_url = Yii::$app->homeUrl;
        }

        parent::init();
    }

	/**
	 * @return string
	 */
	public function run()
    {
        return '<a class="logo" href="'.Html::encode($this->logo_url).'">
                  <span class="logo-mini">'.$this->logo_mini.'</span>
                  <span class="logo-lg">'.$this->logo_lg.'</span>
                </a>';
    }
}
