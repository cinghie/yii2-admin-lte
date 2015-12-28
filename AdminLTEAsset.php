<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-admin-lte
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-AdminLTE
* @version 1.3.5
*/

namespace cinghie\adminlte;

/**
 * Class yii2-AdminLTEAsset
 * @package cinghie\adminlte
 */
class AdminLTEAsset extends \yii\web\AssetBundle
{

    /**
     * @inherit
     */
    public $sourcePath = '@bower/';

    /**
     * @inherit
     */
    public $css = [ 
		'ionicons/css/ionicons.css',
		'admin-lte/dist/css/AdminLTE.css',
		'admin-lte/dist/css/skins/_all-skins.css'
	];
	
	/**
     * @inherit
     */
	public $js = [
		'admin-lte/dist/js/app.js'
	];
	
	/**
     * @inherit
     */
	public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
		'cinghie\fontawesome\FontAwesomeAsset',
    ];

}
