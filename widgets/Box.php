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

use Exception;
use kartik\grid\GridView;
use yii\bootstrap\Widget;

class Box extends Widget
{
    public $buttonLeftTitle;
    public $buttonLeftLink;
    public $buttonLeftType;
    public $buttonRightTitle;
    public $buttonRightLink;
    public $buttonRightType;
    public $class;
    public $columns;
    public $dataProvider;
    public $type;
    public $title;

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        parent::init();

        if ($this->class === null) {
            $this->class = 'col-md-6 col-sm-12 col-xs-12';
        }

        if ($this->columns === null) {
            $this->columns = ['Order ID','Item','Status','Popularity'];
        }

        if ($this->type === null) {
            $this->type = 'box-info';
        }

        if ($this->buttonLeftType === null) {
            $this->buttonLeftType = str_replace('box-', '',$this->type);
        }

        if ($this->buttonRightType === null) {
            $this->buttonRightType = 'default';
        }

        if ($this->title === null) {
            $this->title = 'Box Title';
        }
    }

	/**
	 * @return string
	 * @throws Exception
	 */
	public function run()
    {
        $header = '<div class="box-header with-border">
            <h3 class="box-title">'.$this->title.'</h3>
            <div class="box-tools pull-right">
                <button data-widget="collapse" class="btn btn-box-tool" type="button">
                    <i class="fa fa-minus"></i>
                </button>
                <button data-widget="remove" class="btn btn-box-tool" type="button"><i class="fa fa-times"></i></button>
            </div>
        </div>';

        if($this->dataProvider === null || $this->columns === null) {

            $body = '<div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Item</th>
                                <th>Status</th>
                                <th>Popularity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="#">OR9842</a></td>
                                <td>Call of Duty IV</td>
                                <td><span class="label label-success">Shipped</span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><a href="#">OR1848</a></td>
                                <td>Samsung Smart TV</td>
                                <td><span class="label label-warning">Pending</span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><a href="#">OR7429</a></td>
                                <td>iPhone 6 Plus</td>
                                <td><span class="label label-danger">Delivered</span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><a href="#">OR7429</a></td>
                                <td>Samsung Smart TV</td>
                                <td><span class="label label-info">Processing</span></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>';

        } else {

            $body = '<div class="box-body">'.GridView::widget([
                'columns' => $this->columns,
                'dataProvider' => $this->dataProvider,
                'hover' => true,
                'panel' => false,
                'responsive' => true,
                'summary' => false
            ]).'</div>';

        }

        $footer  = '<div class="box-footer clearfix">';

        if($this->buttonLeftTitle && $this->buttonLeftLink) {
            $footer .= '<a class="btn btn-sm btn-'.$this->buttonLeftType.' btn-flat pull-left" href="'.$this->buttonLeftLink.'">'.$this->buttonLeftTitle.'</a>';
        }

        if($this->buttonRightTitle && $this->buttonRightLink) {
            $footer .= '<a class="btn btn-sm btn-'.$this->buttonRightType.' btn-flat pull-right" href="'.$this->buttonRightLink.'">'.$this->buttonRightTitle.'</a>';
        }

        $footer .= '</div>';

        return '<div class="'.$this->class.'">'.
            '<div class="box '.$this->type.'">'.
            $header.
            $body.
            $footer.
            '</div>'.
        '</div>';
    }
}
