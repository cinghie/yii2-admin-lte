<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-admin-lte
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-AdminLTE
* @version 1.5.2
*/

namespace cinghie\adminlte;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * Class yii2-AdminLTEAsset
 * @package cinghie\adminlte
 */
class AdminLTEMinifyAsset extends AssetBundle
{

    /**
     * @inherit
     */
	public $sourcePath = '@vendor/almasaeed2010/adminlte/dist/';

    /**
     * @inherit
     */
    public $css = [
	    'css/AdminLTE.min.css'
	];
	
	/**
     * @inherit
     */
	public $js = [
		'js/adminlte.min.js'
	];
	
	/**
     * @inherit
     */
	public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
		'cinghie\fontawesome\FontAwesomeMinifyAsset'
    ];

	/**
	 * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
	 * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
	 */
	public $skin = '_all-skins';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		// Append skin color file if specified
		if ($this->skin) {
			if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
				throw new Exception('Invalid skin specified');
			}
			$this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
		}
		parent::init();
	}

}
