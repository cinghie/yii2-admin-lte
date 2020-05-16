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
    public $condensed = false;

    /**
     * @var bool is striped
     */
    public $striped = true;

    /**
     * @var bool is row have hover effect
     */
    public $hover = false;

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
     * @inheritdoc
     */
    public function renderPager()
    {
        return Html::tag('div', parent::renderPager(), ['class' => 'dataTables_paginate paging_simple_numbers']);
    }
}
