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

use Exception;
use Yii;
use kartik\grid\GridView;
use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;
use yii\data\DataProviderInterface;
use yii\helpers\Html;

/**
 * AdminLTE 2 content / dashboard Box.
 *
 * Modes:
 * - Content: {@see begin()} / {@see end()} or `$body` / `$footer`
 * - Grid: `$dataProvider` + `$columns` (+ optional footer buttons)
 *
 * Note: do not pass CSS wrappers as config key `class` — Yii uses `class` for the
 * PHP class name in {@see widget()} / {@see begin()}. Use `$wrapperClass` (preferred)
 * or the legacy key will be remapped automatically when it looks like a CSS class.
 */
class Box extends Widget
{
	/** @var string[] */
	private static $boxTypes = ['default', 'primary', 'info', 'success', 'warning', 'danger'];

	/** @var string[] Bootstrap 3 button contexts used in footer actions */
	private static $buttonTypes = ['default', 'primary', 'success', 'info', 'warning', 'danger', 'link'];

	/**
	 * @var string|null Left footer button label (grid mode)
	 */
	public $buttonLeftTitle;

	/**
	 * @var string|null Left footer button URL (grid mode)
	 */
	public $buttonLeftLink;

	/**
	 * @var string|null Bootstrap button type without `btn-` (default: derived from box type)
	 */
	public $buttonLeftType;

	/**
	 * @var string|null Right footer button label (grid mode)
	 */
	public $buttonRightTitle;

	/**
	 * @var string|null Right footer button URL (grid mode)
	 */
	public $buttonRightLink;

	/**
	 * @var string|null Bootstrap button type without `btn-` (default: default)
	 */
	public $buttonRightType = 'default';

	/**
	 * Legacy CSS column wrapper. Prefer {@see $wrapperClass}.
	 * Avoid setting via widget config key `class` (conflicts with Yii DI); use `wrapperClass`.
	 *
	 * @var string|null
	 */
	public $class;

	/**
	 * Column wrapper (e.g. `col-md-6`). Null = no wrapper.
	 * Grid mode defaults to `col-md-6 col-sm-12 col-xs-12` when unset.
	 *
	 * @var string|null
	 */
	public $wrapperClass;

	/**
	 * @var array|null GridView columns (grid mode)
	 */
	public $columns;

	/**
	 * @var DataProviderInterface|null
	 */
	public $dataProvider;

	/**
	 * Box color: `info|warning|success|primary|danger|default`, or legacy `box-info`.
	 *
	 * @var string
	 */
	public $type = 'info';

	/**
	 * @var string|null
	 */
	public $title;

	/**
	 * Icon class for the title (e.g. `fa fa-upload`)
	 *
	 * @var string|null
	 */
	public $titleIcon;

	/**
	 * @var bool
	 */
	public $encodeTitle = true;

	/**
	 * Body when using {@see widget()}; ignored if begin/end captures content.
	 *
	 * @var string
	 */
	public $body = '';

	/**
	 * @var bool
	 */
	public $encodeBody = true;

	/**
	 * Footer HTML/text (content mode). Grid mode builds footer from buttons when empty.
	 *
	 * @var string|null
	 */
	public $footer;

	/**
	 * @var bool
	 */
	public $encodeFooter = true;

	/**
	 * Add `with-border` on box-header.
	 *
	 * @var bool
	 */
	public $withBorder = true;

	/**
	 * Show collapse tool. Null = auto (true in grid mode, false in content mode).
	 *
	 * @var bool|null
	 */
	public $collapsible;

	/**
	 * Show remove tool. Null = auto (true in grid mode, false in content mode).
	 *
	 * @var bool|null
	 */
	public $removable;

	/**
	 * @var array
	 */
	public $options = [];

	/**
	 * @var array
	 */
	public $headerOptions = [];

	/**
	 * @var array
	 */
	public $bodyOptions = [];

	/**
	 * @var array
	 */
	public $footerOptions = [];

	/**
	 * Whether output buffering was started for begin/end content capture.
	 *
	 * @var bool
	 */
	private $_buffering = false;

	/**
	 * Output buffer nesting level opened by this widget (0 = none).
	 *
	 * @var int
	 */
	private $_bufferLevel = 0;

	/**
	 * {@inheritdoc}
	 */
	public static function begin($config = [])
	{
		return parent::begin(static::normalizeConfig($config));
	}

	/**
	 * {@inheritdoc}
	 */
	public static function widget($config = [])
	{
		return parent::widget(static::normalizeConfig($config));
	}

	/**
	 * Remap legacy CSS `class` config to `wrapperClass` before Yii steals `class` for DI.
	 *
	 * @param array $config
	 * @return array
	 */
	protected static function normalizeConfig(array $config)
	{
		if (!isset($config['class']) || !is_string($config['class'])) {
			return $config;
		}

		$value = $config['class'];
		// FQCN / short class names used by DI — leave alone (widget()/begin() set these)
		if (strpos($value, '\\') !== false || class_exists($value, false)) {
			return $config;
		}

		if (!isset($config['wrapperClass']) || $config['wrapperClass'] === null || $config['wrapperClass'] === '') {
			$config['wrapperClass'] = $value;
		}
		unset($config['class']);

		return $config;
	}

	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
		parent::init();

		if ($this->isGridMode()) {
			if (($this->wrapperClass === null || $this->wrapperClass === '')
				&& ($this->class === null || $this->class === '')
			) {
				$this->wrapperClass = 'col-md-6 col-sm-12 col-xs-12';
			}
			if ($this->buttonLeftType === null || $this->buttonLeftType === '') {
				$this->buttonLeftType = $this->normalizeType($this->type);
			}
		}

		// Always buffer so begin()/end() body capture works; grid mode discards it in run()
		$this->_buffering = true;
		ob_start();
		ob_implicit_flush(false);
		$this->_bufferLevel = ob_get_level();
	}

	/**
	 * {@inheritdoc}
	 * @return string
	 * @throws Exception
	 */
	public function run()
	{
		try {
			$this->registerBoxHeaderCss();

			if ($this->isGridMode()) {
				$this->discardBuffer();

				return $this->renderGridBox();
			}

			return $this->renderContentBox();
		} finally {
			$this->discardBuffer();
		}
	}

	/**
	 * @return bool
	 */
	protected function isGridMode()
	{
		return $this->dataProvider !== null;
	}

	/**
	 * Drop any leftover content buffer (e.g. after an exception in run()).
	 * Only closes the buffer opened by this widget — never a parent buffer.
	 */
	protected function discardBuffer()
	{
		if (!$this->_buffering) {
			return;
		}
		if ($this->_bufferLevel > 0 && ob_get_level() === $this->_bufferLevel) {
			ob_end_clean();
		}
		$this->_buffering = false;
		$this->_bufferLevel = 0;
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	protected function renderGridBox()
	{
		$type = $this->normalizeType($this->type);
		$collapsible = $this->resolveToolFlag($this->collapsible, true);
		$removable = $this->resolveToolFlag($this->removable, true);

		Html::addCssClass($this->options, ['box', 'box-' . $type, 'cinghie-adminlte-box']);

		$html = $this->renderHeader($collapsible, $removable);

		$bodyOptions = $this->bodyOptions;
		Html::addCssClass($bodyOptions, 'box-body');
		$html .= Html::tag('div', $this->renderGridBody(), $bodyOptions);
		$html .= $this->renderGridFooter($type);

		return $this->wrap(Html::tag('div', $html, $this->options));
	}

	/**
	 * @return string
	 */
	protected function renderContentBox()
	{
		$captured = '';
		if ($this->_buffering) {
			if ($this->_bufferLevel > 0 && ob_get_level() === $this->_bufferLevel) {
				$captured = (string) ob_get_clean();
			}
			$this->_buffering = false;
			$this->_bufferLevel = 0;
		}

		if (trim($captured) !== '') {
			$bodyHtml = $captured;
		} else {
			$bodyHtml = $this->encodeBody ? Html::encode((string) $this->body) : (string) $this->body;
		}

		$type = $this->normalizeType($this->type);
		$collapsible = $this->resolveToolFlag($this->collapsible, false);
		$removable = $this->resolveToolFlag($this->removable, false);

		Html::addCssClass($this->options, ['box', 'box-' . $type, 'cinghie-adminlte-box']);

		$html = $this->renderHeader($collapsible, $removable);

		if ($bodyHtml !== '') {
			$bodyOptions = $this->bodyOptions;
			Html::addCssClass($bodyOptions, 'box-body');
			$html .= Html::tag('div', $bodyHtml, $bodyOptions);
		}

		$html .= $this->renderContentFooter();

		return $this->wrap(Html::tag('div', $html, $this->options));
	}

	/**
	 * @param string $html
	 * @return string
	 */
	protected function wrap($html)
	{
		$wrapper = ($this->wrapperClass !== null && $this->wrapperClass !== '')
			? $this->wrapperClass
			: $this->class;

		if ($wrapper === null || $wrapper === '') {
			return $html;
		}

		return Html::tag('div', $html, ['class' => $wrapper]);
	}

	/**
	 * @param bool|null $flag
	 * @param bool $default
	 * @return bool
	 */
	protected function resolveToolFlag($flag, $default)
	{
		return $flag !== null ? (bool) $flag : $default;
	}

	/**
	 * @param bool $collapsible
	 * @param bool $removable
	 * @return string
	 */
	protected function renderHeader($collapsible, $removable)
	{
		$hasTitle = ($this->title !== null && $this->title !== '')
			|| ($this->titleIcon !== null && $this->titleIcon !== '');
		$hasTools = $collapsible || $removable;

		if (!$hasTitle && !$hasTools) {
			return '';
		}

		$parts = [];

		if ($hasTitle) {
			$title = $this->encodeTitle ? Html::encode((string) $this->title) : (string) $this->title;
			$inner = '';
			if ($this->titleIcon !== null && $this->titleIcon !== '') {
				$inner .= Html::tag('i', '', ['class' => $this->titleIcon]) . ' ';
			}
			$inner .= $title;
			$parts[] = Html::tag('h3', $inner, ['class' => 'box-title']);
		}

		if ($hasTools) {
			$tools = '';
			if ($collapsible) {
				$tools .= Html::button(
					Html::tag('i', '', ['class' => 'fa fa-minus']),
					[
						'type' => 'button',
						'class' => 'btn btn-box-tool',
						'data-widget' => 'collapse',
					]
				);
			}
			if ($removable) {
				$tools .= Html::button(
					Html::tag('i', '', ['class' => 'fa fa-times']),
					[
						'type' => 'button',
						'class' => 'btn btn-box-tool',
						'data-widget' => 'remove',
					]
				);
			}
			$parts[] = Html::tag('div', $tools, ['class' => 'box-tools pull-right']);
		}

		$headerOptions = $this->headerOptions;
		$classes = ['box-header'];
		if ($this->withBorder) {
			$classes[] = 'with-border';
		}
		Html::addCssClass($headerOptions, $classes);

		return Html::tag('div', implode("\n", $parts), $headerOptions);
	}

	/**
	 * @return string
	 * @throws Exception
	 * @throws InvalidConfigException
	 */
	protected function renderGridBody()
	{
		if ($this->columns === null) {
			throw new InvalidConfigException('Box grid mode requires a "columns" array.');
		}
		if (!class_exists(GridView::class)) {
			throw new InvalidConfigException(
				'Box grid mode requires kartik-v/yii2-grid (kartik\\grid\\GridView).'
			);
		}

		return GridView::widget([
			'columns' => $this->columns,
			'dataProvider' => $this->dataProvider,
			'hover' => true,
			'panel' => false,
			'responsive' => true,
			'summary' => false,
		]);
	}

	/**
	 * @param string $type Normalized box type (info, warning, …)
	 * @return string
	 */
	protected function renderGridFooter($type)
	{
		if ($this->footer !== null && $this->footer !== '') {
			return $this->renderContentFooter();
		}

		$leftType = $this->normalizeButtonType(
			($this->buttonLeftType !== null && $this->buttonLeftType !== '')
				? $this->buttonLeftType
				: $type
		);
		$rightType = $this->normalizeButtonType(
			($this->buttonRightType !== null && $this->buttonRightType !== '')
				? $this->buttonRightType
				: 'default'
		);

		$content = '';
		if ($this->buttonLeftTitle && $this->buttonLeftLink) {
			$content .= Html::a(
				$this->buttonLeftTitle,
				$this->sanitizeActionUrl($this->buttonLeftLink),
				['class' => 'btn btn-sm btn-' . $leftType . ' btn-flat pull-left']
			);
		}
		if ($this->buttonRightTitle && $this->buttonRightLink) {
			$content .= Html::a(
				$this->buttonRightTitle,
				$this->sanitizeActionUrl($this->buttonRightLink),
				['class' => 'btn btn-sm btn-' . $rightType . ' btn-flat pull-right']
			);
		}

		if ($content === '') {
			return '';
		}

		$footerOptions = $this->footerOptions;
		Html::addCssClass($footerOptions, ['box-footer', 'clearfix']);

		return Html::tag('div', $content, $footerOptions);
	}

	/**
	 * @return string
	 */
	protected function renderContentFooter()
	{
		if ($this->footer === null || $this->footer === '') {
			return '';
		}

		$content = $this->encodeFooter ? Html::encode($this->footer) : $this->footer;
		$footerOptions = $this->footerOptions;
		Html::addCssClass($footerOptions, ['box-footer', 'clearfix', 'no-border']);

		return Html::tag('div', $content, $footerOptions);
	}

	/**
	 * @param string $type
	 * @return string
	 */
	protected function normalizeType($type)
	{
		$type = strtolower(trim((string) $type));
		if (strpos($type, 'box-') === 0) {
			$type = substr($type, 4);
		}

		return in_array($type, self::$boxTypes, true) ? $type : 'info';
	}

	/**
	 * @param string $type
	 * @return string
	 */
	protected function normalizeButtonType($type)
	{
		$type = strtolower(trim((string) $type));
		if (strpos($type, 'btn-') === 0) {
			$type = substr($type, 4);
		}
		if (strpos($type, 'box-') === 0) {
			$type = substr($type, 4);
		}

		return in_array($type, self::$buttonTypes, true) ? $type : 'default';
	}

	/**
	 * Block javascript:/data: action URLs on grid footer buttons.
	 *
	 * @param mixed $url
	 * @return mixed
	 */
	protected function sanitizeActionUrl($url)
	{
		if (!is_string($url)) {
			return $url;
		}
		$trimmed = ltrim($url);
		if (preg_match('#^(javascript|data)\s*:#i', $trimmed)) {
			return '#';
		}

		return $url;
	}

	/**
	 * Vertically center icon + title in AdminLTE 2 box-header.
	 */
	protected function registerBoxHeaderCss()
	{
		static $registered = false;
		if ($registered || !Yii::$app->has('view')) {
			return;
		}
		$registered = true;

		Yii::$app->view->registerCss(<<<'CSS'
.cinghie-adminlte-box > .box-header {
	display: flex;
	align-items: center;
}
.cinghie-adminlte-box > .box-header .box-title {
	display: inline-flex;
	align-items: center;
	margin: 0;
	line-height: 1.25;
	float: none;
}
.cinghie-adminlte-box > .box-header .box-title > i {
	margin-right: 8px;
	line-height: 1;
}
.cinghie-adminlte-box > .box-header .box-tools {
	margin-left: auto;
}
CSS
			, [], 'cinghie-adminlte-box-header');
	}
}
