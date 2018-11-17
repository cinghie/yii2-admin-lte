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

use yii\bootstrap\Widget;
use yii\helpers\Html;

class NavbarUser extends Widget
{
    public $username;
    public $userimg;
    public $usercreated;
    public $userbody;
    public $userbodyname1;
    public $userbodylink1;
    public $userbodyname2;
    public $userbodylink2;
    public $userbodyname3;
    public $userbodylink3;
    public $userfooter;
    public $userfootername1;
    public $userfooterlink1;
    public $userfootername2;
    public $userfooterlink2;

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        if ($this->username === null) {
            $this->username = 'Alexander Pierce';
        }

        if ($this->userimg === null) {
            $this->userimg = 'https://cdn0.iconfinder.com/data/icons/user-pictures/100/matureman1-2-128.png';
        }

        if ($this->usercreated === null) {
            $this->usercreated = '2015-01-01 12:30:01';
        }

        if ($this->userbody === null) {
            $this->userbody = true;
        }

        if ($this->userbodyname1 === null) {
            $this->userbodyname1 = 'Followers';
        }

        if ($this->userbodylink1 === null) {
            $this->userbodylink1 = '#';
        }

        if ($this->userbodyname2 === null) {
            $this->userbodyname2 = 'Sales';
        }

        if ($this->userbodylink2 === null) {
            $this->userbodylink2 = '#';
        }

        if ($this->userbodyname3 === null) {
            $this->userbodyname3 = 'Friends';
        }

        if ($this->userbodylink3 === null) {
            $this->userbodylink3 = '#';
        }

        if ($this->userfooter === null) {
            $this->userfooter = true;
        }

        if ($this->userfootername1 === null) {
            $this->userfootername1 = 'Profile';
        }

        if ($this->userfooterlink1 === null) {
            $this->userfooterlink1 = '#';
        }

        if ($this->userfootername2 === null) {
            $this->userfootername2 = 'Sign Out';
        }

        if ($this->userfooterlink2 === null) {
            $this->userfooterlink2 = '#';
        }

    }

	/**
	 * @return string
	 */
	public function run()
    {
        $html = '<li class="dropdown user user-menu">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <img alt="'.Html::encode($this->username).'" class="user-image" src="'.Html::encode($this->userimg).'">
                          <span class="hidden-xs">'.Html::encode($this->username).'</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img  alt="'.Html::encode($this->username).'" class="img-circle" src="'.Html::encode($this->userimg).'">
                            <p>'.Html::encode($this->username).'
                                <small>'.Html::encode($this->usercreated).'</small>
                            </p>
                        </li>';

        if($this->userbody):
            $html .=   '<li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="'.Html::encode($this->userbodylink1).'">'.Html::encode($this->userbodyname1).'</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="'.Html::encode($this->userbodylink2).'">'.Html::encode($this->userbodyname2).'</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="'.Html::encode($this->userbodylink3).'">'.Html::encode($this->userbodyname3).'</a>
                                </div>
                            </div>
                          </li>';
        endif;

        if($this->userfooter):
            $html .=     '<li class="user-footer">
                            <div class="pull-left">
                                <a class="btn btn-default btn-flat" href="'.Html::encode($this->userfooterlink1).'">'.Html::encode($this->userfootername1).'</a>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-default btn-flat" href="'.Html::encode($this->userfooterlink2).'">'.Html::encode($this->userfootername2).'</a>
                            </div>
                          </li>';
        endif;

        $html .=       '</ul>
                   </li>';

        return $html;
    }

}
