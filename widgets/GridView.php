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
	 * @var boolean whether the grid view will be rendered within a pjax container. Defaults to `false`. If set to
	 * `true`, the entire GridView widget will be parsed via Pjax and auto-rendered inside a yii\widgets\Pjax
	 * widget container. If set to `false` pjax will be disabled and none of the pjax settings will be applied.
	 */
	public $pjax = true;

	/**
	 * @var array the pjax settings for the widget. This will be considered only when [[pjax]] is set to true. The
	 * following settings are recognized:
	 * - `neverTimeout`: `boolean`, whether the pjax request should never timeout. Defaults to `true`. The pjax:timeout
	 *   event will be configured to disable timing out of pjax requests for the pjax container.
	 * - `options`: _array_, the options for the [[\yii\widgets\Pjax]] widget.
	 * - `loadingCssClass`: boolean/string, the CSS class to be applied to the grid when loading via pjax. If set to
	 *   `false` - no css class will be applied. If it is empty, null, or set to `true`, will default to
	 *   `kv-grid-loading`.
	 * - `beforeGrid`: _string_, any content to be embedded within pjax container before the Grid widget.
	 * - `afterGrid`: _string_, any content to be embedded within pjax container after the Grid widget.
	 */
	public $pjaxSettings = [
		'neverTimeout' => true,
	];

	/**
	 * @var boolean whether the grid will highlight row on `hover`. Applicable only if `bootstrap` is `true`.
	 */
	public $hover = true;
}