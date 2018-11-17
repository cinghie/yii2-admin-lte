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

class SidebarToggle extends Widget
{
	/**
	 * @return string
	 */
	public function run()
    {
        return '<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        			<span class="sr-only">Toggle navigation</span>
      			</a>';
    }
}
