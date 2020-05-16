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
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Menu;

/**
 * Class SidebarMenu
 */
class SidebarMenu extends Menu
{
	/**
	 * @var string
	 **/
	public $linkTemplate = '<a href="{url}">{icon} {label}</a>';

	/**
	 * @var string
	 **/
	public $labelTemplate = '<span>{label}</span>';

	/**
	 * @var string
	 **/
	public $submenuTemplate = "\n<ul class='treeview-menu' {show}>\n{items}\n</ul>\n";

	/**
	 * @var boolean
	 **/
	public $activateParents = true;

	/**
	 * @var string
	 **/
	public $defaultIconHtml = '';

	/**
	 * @var array
	 **/
	public $options = ['class' => 'sidebar-menu', 'data-widget' => 'tree'];

	/**
	 * @var string
	 */
	public static $iconClassPrefix = '';

	/**
	 * @var boolean
	 **/
	private $noDefaultAction;

	/**
	 * @var boolean
	 **/
	private $noDefaultRoute;

	/**
	 * Renders the menu.
	 */
	public function run()
	{
		if ($this->route === null && Yii::$app->controller !== null) {
			$this->route = Yii::$app->controller->getRoute();
		}

		if ($this->params === null) {
			$this->params = Yii::$app->request->getQueryParams();
		}

		$posDefaultAction = strpos($this->route, Yii::$app->controller->defaultAction);

		if ($posDefaultAction) {
			$this->noDefaultAction = rtrim(substr($this->route, 0, $posDefaultAction), '/');
		} else {
			$this->noDefaultAction = false;
		}

		$posDefaultRoute = strpos($this->route, Yii::$app->controller->module->defaultRoute);

		if ($posDefaultRoute) {
			$this->noDefaultRoute = rtrim(substr($this->route, 0, $posDefaultRoute), '/');
		} else {
			$this->noDefaultRoute = false;
		}

		$items = $this->normalizeItems($this->items, $hasActiveChild);

		if (!empty($items))
		{
			$options = $this->options;
			$tag = ArrayHelper::remove($options, 'tag', 'ul');
			echo Html::tag($tag, $this->renderItems($items), $options);
		}
	}

	/**
	 * @inheritdoc
	 */
	protected function renderItem($item)
	{
		if (isset($item['items'])) {
			$labelTemplate = '<a href="{url}">{icon} {label} <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
			$linkTemplate = '<a href="{url}">{icon} {label} <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
		} else {
			$labelTemplate = $this->labelTemplate;
			$linkTemplate = $this->linkTemplate;
		}

		$replacements = [
			'{label}' => strtr($this->labelTemplate, ['{label}' => $item['label'],]),
			'{icon}' => empty($item['icon']) ? $this->defaultIconHtml
				: '<i class="' . self::$iconClassPrefix . $item['icon'] . '"></i> ',
			'{url}' => isset($item['url']) ? Url::to($item['url']) : 'javascript:void(0);',
		];

		$template = ArrayHelper::getValue($item, 'template', isset($item['url']) ? $linkTemplate : $labelTemplate);

		return strtr($template, $replacements);
	}

	/**
	 * Recursively renders the menu items (without the container tag)
     *
	 * @param array $items the menu items to be rendered recursively
     *
	 * @return string the rendering result
	 */
	protected function renderItems($items)
	{
		$n = count($items);
		$lines = [];

		foreach ($items as $i => $item)
		{
			$options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
			$tag = ArrayHelper::remove($options, 'tag', 'li');
			$class = [];

			if ($item['active']) {
				$class[] = $this->activeCssClass;
			}

			if ($i === 0 && $this->firstItemCssClass !== null) {
				$class[] = $this->firstItemCssClass;
			}

			if ($i === $n - 1 && $this->lastItemCssClass !== null) {
				$class[] = $this->lastItemCssClass;
			}

			if (!empty($class))
			{
				if (empty($options['class'])) {
					$options['class'] = implode(' ', $class);
				} else {
					$options['class'] .= ' ' . implode(' ', $class);
				}
			}

			$menu = $this->renderItem($item);

			if (!empty($item['items']))
			{
				$menu .= strtr($this->submenuTemplate, [
					'{show}' => $item['active'] ? "style='display: block'" : '',
					'{items}' => $this->renderItems($item['items']),
				]);
				if (isset($options['class'])) {
					$options['class'] .= ' treeview';
				} else {
					$options['class'] = 'treeview';
				}
			}

			$lines[] = Html::tag($tag, $menu, $options);
		}

		return implode("\n", $lines);
	}

	/**
	 * @inheritdoc
	 */
	protected function normalizeItems($items, &$active)
	{
		foreach ($items as $i => $item)
		{
			if (isset($item['visible']) && !$item['visible']) {
				unset($items[$i]);
				continue;
			}

			if (!isset($item['label'])) {
				$item['label'] = '';
			}

			$encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
			$items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
			$items[$i]['icon'] = isset($item['icon']) ? $item['icon'] : '';
			$hasActiveChild = false;

			if (isset($item['items'])) {
				$items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
				if (empty($items[$i]['items']) && $this->hideEmptyItems) {
					unset($items[$i]['items']);
					if (!isset($item['url'])) {
						unset($items[$i]);
						continue;
					}
				}
			}

			if (!isset($item['active']))
			{
				if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
					$active = $items[$i]['active'] = true;
				} else {
					$items[$i]['active'] = false;
				}
			} elseif ($item['active']) {
				$active = true;
			}
		}

		return array_values($items);
	}

	/**
	 * @param array $item the menu item to be checked
	 *
	 * @return boolean whether the menu item is active
	 */
	protected function isItemActive($item)
	{
		if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0]))
		{
			$route = $item['url'][0];

			if ($route[0] !== '/' && Yii::$app->controller) {
				$route = ltrim(Yii::$app->controller->module->getUniqueId() . '/' . $route, '/');
			}

			$route = ltrim($route, '/');

			if ($route !== $this->route && $route !== $this->noDefaultRoute && $route !== $this->noDefaultAction) {
				return false;
			}

			unset($item['url']['#']);

			if (count($item['url']) > 1) {
				foreach (array_splice($item['url'], 1) as $name => $value) {
					if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] !== $value)) {
						return false;
					}
				}
			}

			return true;
		}

		return false;
	}
}
