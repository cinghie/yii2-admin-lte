<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-admin-lte
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-AdminLTE
* @version 1.0.1
*/

namespace cinghie\adminlte;

use cinghie\fontawesome\FontAwesomeAsset;

/**
 * Class yii2-AdminLTEAsset
 * @package cinghie\adminlte
 */
class AdminLTEMinifyAsset extends \yii\web\AssetBundle
{

    /**
     * @inherit
     */
    public $sourcePath = '@bower/admin-lte/dist/';

    /**
     * @inherit
     */
    public $css = [ 
		'css/AdminLTE.min.css',
		'css/skins/_all-skins.min.css'
	];
	
	/**
     * @inherit
     */
	public $js = [
		'js/app.min.js'
	];
	
	/**
     * @inherit
     */
	public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
		'cinghie\fontawesome\FontAwesomeMinifyAsset',
    ];

}