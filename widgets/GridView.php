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

use yii\base\InvalidConfigException;
use kartik\grid\GridView as baseGrid;
use yii\helpers\Html;

/**
 * Class GridView
 */
class GridView extends baseGrid
{
    /**
     * @var string
     */
    public $dataColumnClass = DataColumn::class;

    /**
     * @var array
     */
    public $tableOptions = ['class' => 'table dataTable'];

    /**
     * @var string
     */
    public $boxClass = 'box-info';

    /**
     * @var bool is bordered
     */
    public $bordered = true;

    /**
     * @var bool is condensed
     */
    public $condensed = true;

    /**
     * @var bool is striped
     */
    public $striped = true;

    /**
     * @var bool is row have hover effect
     */
    public $hover = true;

    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The layout template will be automatically set based on the [[panel]] setting. If [[panel]] is a valid
     * array, then the [[layout]] will default to the [[panelTemplate]] property. If the [[panel]] property
     * is set to `false`, then the [[layout]] will default to `{summary}\n{items}\n{pager}`.
     *
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{errors}`: the filter model error summary. See [[renderErrors()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     * - `{export}`: the grid export button menu. See [[renderExport()]].
     * - `{toolbar}`: the grid panel toolbar. See [[renderToolbar()]].
     * - `{toolbarContainer}`: the toolbar container. See [[renderToolbarContainer()]].
     *
     * In addition to the above tokens, refer the [[panelTemplate]] property for other tokens supported as
     * part of the bootstrap styled panel.
     *
     */
    public $layout = "{summary}\n{items}\n{pager}";

    /**
     * @var boolean whether the grid will have a `responsive` style. Applicable only if `bootstrap` is `true`.
     */
    public $responsive = true;

    /**
     * @var boolean whether the grid will automatically wrap to fit columns for smaller display sizes.
     */
    public $responsiveWrap = true;

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
        'neverTimeout'=>true,
    ];

    /**
     * @inheritdoc
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->bordered) {
            Html::addCssClass($this->tableOptions, 'table-bordered');
        }

        if ($this->condensed) {
            Html::addCssClass($this->tableOptions, 'table-condensed');
        }

        if ($this->striped) {
            Html::addCssClass($this->tableOptions, 'table-striped');
        }

        if ($this->hover) {
            Html::addCssClass($this->tableOptions, 'table-hover');
        }

        parent::init();
    }

    /**
     * @return string|void
     * @throws InvalidConfigException
     */
    public function run()
    {
        echo '<div class="box '.$this->boxClass.'">';
        parent::run();
        echo '</div>';
    }

    /**
     * @inheritdoc
     */
    public function renderPager()
    {
        return Html::tag('div', parent::renderPager(), ['class' => 'dataTables_paginate paging_simple_numbers']);
    }
}
