<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-admin-lte
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-AdminLTE
 * @version 1.3.10
 */

namespace cinghie\adminlte\widgets;

use yii\bootstrap\Widget;

class SidebarToggle extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return '<a role="button" data-toggle="offcanvas" class="sidebar-toggle" href="#">
                    <span class="sr-only">Toggle navigation</span>
                </a>';
    }

}
