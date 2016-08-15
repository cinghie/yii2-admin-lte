<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-admin-lte
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-AdminLTE
 * @version 1.3.8
 */

namespace cinghie\adminlte\widgets;

use yii\bootstrap\Widget;

class Box extends Widget
{
    public $buttonLeftTitle;
    public $buttonLeftLink;
    public $buttonRightTitle;
    public $buttonRightLink;
    public $type;
    public $title;

    public function init()
    {
        parent::init();

        if ($this->type === null) {
            $this->type = 'box-info';
        }
        if ($this->title === null) {
            $this->title = 'Box Title';
        }
    }

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
                            <td><a href="pages/examples/invoice.html">OR9842</a></td>
                            <td>Call of Duty IV</td>
                            <td><span class="label label-success">Shipped</span></td>
                            <td>
                              <div data-height="20" data-color="#00a65a" class="sparkbar"><canvas style="display: inline-block; width: 34px; height: 20px; vertical-align: top;" width="34" height="20"></canvas></div>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="pages/examples/invoice.html">OR1848</a></td>
                            <td>Samsung Smart TV</td>
                            <td><span class="label label-warning">Pending</span></td>
                            <td>
                              <div data-height="20" data-color="#f39c12" class="sparkbar"><canvas style="display: inline-block; width: 34px; height: 20px; vertical-align: top;" width="34" height="20"></canvas></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';

        $footer  = '<div class="box-footer clearfix">';

        if($this->buttonLeftTitle && $this->buttonLeftLink) {
            $footer .= '<a class="btn btn-sm btn-info btn-flat pull-left" href="'.$this->buttonLeftLink.'">'.$this->buttonLeftTitle.'</a>';
        }

        if($this->buttonRightTitle && $this->buttonRightLink) {
            $footer .= '<a class="btn btn-sm btn-default btn-flat pull-right" href="'.$this->buttonRightLink.'">'.$this->buttonRightTitle.'</a>';
        }

        $footer .= '</div>';

        return '<div class="box '.$this->type.'">'.
            $header.
            $body.
            $footer.
        '</div>';
    }
}
