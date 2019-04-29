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

use kartik\grid\GridView as BaseGridView;

class GridView extends BaseGridView
{
	/**
	 * @var boolean
	 */
	public $hover = true;

	/**
	 * @var boolean
	 */
	public $pjax = true;

	/**
	 * @var array
	 */
	public $pjaxSettings = [
		'neverTimeout' => true,
	];
}