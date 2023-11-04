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

namespace cinghie\adminlte;

use cinghie\fontawesome\FontAwesomeAsset;
use cinghie\ionicons\IoniconsAsset;
use yii\base\Exception;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Class AdminLTEAsset
 */
class AdminLTEAsset extends AssetBundle
{
	/**
	 * @inherit
	 */
	public $sourcePath = '@vendor/almasaeed2010/adminlte/';

	/**
	 * @inherit
	 */
	public $css = [
		'bower_components/datatables.net-bs/css/dataTables.bootstrap.css',
		'bower_components/jvectormap/jquery-jvectormap.css',
		'dist/css/AdminLTE.css'
	];

	/**
	 * @inherit
	 */
	public $js = [
		'bower_components/datatables.net/js/jquery.dataTables.js',
		'bower_components/datatables.net-bs/js/dataTables.bootstrap.js',
		'bower_components/fastclick/lib/fastclick.js',
		'dist/js/adminlte.js',
		'bower_components/jquery-sparkline/dist/jquery.sparkline.js',
		'bower_components/jvectormap/jquery-jvectormap.js',
		'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
		'bower_components/chart.js/Chart.js',
	];

	/**
     * @inherit
     */
	public $depends = [
		YiiAsset::class,
		BootstrapAsset::class,
		BootstrapPluginAsset::class,
		FontAwesomeAsset::class,
		IoniconsAsset::class
    ];

	/**
	 * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
	 *
	 * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
	 */
	public $skin = '_all-skins';

	/**
	 * Append skin color file if specified
	 *
	 * @throws Exception
	 */
	public function init()
	{
		if ($this->skin) {
			if (('_all-skins' !== $this->skin) && (!str_starts_with($this->skin, 'skin-'))) {
				throw new Exception('Invalid skin specified');
			}
			$this->css[] = sprintf('dist/css/skins/%s.min.css', $this->skin);
		}

		parent::init();
	}
}
