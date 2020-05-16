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
     * @var boolean whether the grid will have a `responsive` style. Applicable only if `bootstrap` is `true`.
     */
    public $responsive = true;

    /**
     * @var boolean whether the grid will automatically wrap to fit columns for smaller display sizes.
     */
    public $responsiveWrap = true;

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
        //echo '<div class="box box-info">';
        parent::run();
        //echo '</div>';
    }

    /**
     * @inheritdoc
     */
    public function renderPager()
    {
        return Html::tag('div', parent::renderPager(), ['class' => 'dataTables_paginate paging_simple_numbers']);
    }
}
