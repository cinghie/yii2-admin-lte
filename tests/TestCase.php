<?php

namespace cinghie\adminlte\tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Yii;
use yii\caching\ArrayCache;
use yii\helpers\ArrayHelper;
use yii\web\Application;

/**
 * Boots a minimal Yii web application for AdminLTE widget tests.
 */
abstract class TestCase extends BaseTestCase
{
	/**
	 * @param array $appConfig
	 */
	protected function mockApplication(array $appConfig = []): void
	{
		$this->destroyApplication();

		$runtime = dirname(__DIR__) . '/tests/runtime';
		if (!is_dir($runtime)) {
			mkdir($runtime, 0777, true);
		}
		$assets = $runtime . '/assets';
		if (!is_dir($assets)) {
			mkdir($assets, 0777, true);
		}

		$vendorPath = dirname(dirname(dirname(__DIR__)));

		$config = ArrayHelper::merge([
			'id' => 'adminlte-tests',
			'basePath' => dirname(__DIR__) . '/tests',
			'vendorPath' => $vendorPath,
			'runtimePath' => $runtime,
			'aliases' => [
				'@vendor' => $vendorPath,
				'@bower' => $vendorPath . '/bower-asset',
				'@npm' => $vendorPath . '/npm-asset',
			],
			'modules' => class_exists(\kartik\grid\Module::class)
				? ['gridview' => ['class' => \kartik\grid\Module::class]]
				: [],
			'components' => [
				'errorHandler' => [
					'class' => SilentErrorHandler::class,
				],
				'cache' => [
					'class' => ArrayCache::class,
				],
				'session' => [
					'class' => \yii\web\Session::class,
					'useCookies' => false,
				],
				'request' => [
					'class' => \yii\web\Request::class,
					'cookieValidationKey' => 'adminlte-test-key',
					'scriptFile' => __DIR__ . '/index.php',
					'scriptUrl' => '/index.php',
					'hostInfo' => 'https://example.test',
					'url' => '/',
				],
				'assetManager' => [
					'basePath' => $assets,
					'baseUrl' => '/assets',
					'bundles' => [
						\yii\web\YiiAsset::class => false,
						\yii\web\JqueryAsset::class => false,
						\yii\bootstrap\BootstrapAsset::class => false,
						\yii\bootstrap\BootstrapPluginAsset::class => false,
					],
				],
				'i18n' => [
					'translations' => [
						'*' => [
							'class' => \yii\i18n\PhpMessageSource::class,
							'sourceLanguage' => 'en',
							'basePath' => $vendorPath . '/cinghie/yii2-traits/messages',
						],
						'traits' => [
							'class' => \yii\i18n\PhpMessageSource::class,
							'basePath' => $vendorPath . '/cinghie/yii2-traits/messages',
							'sourceLanguage' => 'en',
						],
						'crm*' => [
							'class' => \yii\i18n\PhpMessageSource::class,
							'basePath' => $vendorPath . '/cinghie/yii2-crm/messages',
							'sourceLanguage' => 'en',
						],
					],
				],
				'log' => [
					'traceLevel' => 0,
					'targets' => [],
				],
			],
		], $appConfig);

		new Application($config);
		Yii::$app->session->open();
	}

	protected function destroyApplication(): void
	{
		if (Yii::$app ?? null) {
			if (Yii::$app->has('session', true) && Yii::$app->session->getIsActive()) {
				Yii::$app->session->close();
			}
			Yii::$app = null;
		}
	}

	protected function tearDown(): void
	{
		$this->destroyApplication();
		parent::tearDown();
	}
}
