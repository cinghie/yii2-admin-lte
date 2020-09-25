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

use kartik\grid\DataColumn as baseDataColumn;
use yii\helpers\Html;

/**
 * Class DataColumn
 */
class DataColumn extends baseDataColumn
{
    /**
     * @return string
     */
    public function renderHeaderCell()
    {
        $provider = $this->grid->dataProvider;

        if ($this->attribute !== null && $this->enableSorting && ($sort = $provider->getSort()) !== false && $sort->hasAttribute($this->attribute))
        {
            if (($direction = $sort->getAttributeOrder($this->attribute)) !== null) {
                Html::addCssClass($this->headerOptions, 'sorting_' . ($direction === SORT_DESC ? 'desc' : 'asc'));
            } else {
                Html::addCssClass($this->headerOptions, 'sorting');
            }
        }

        return Html::tag('th', $this->renderHeaderCellContent(), $this->headerOptions);
    }
}
