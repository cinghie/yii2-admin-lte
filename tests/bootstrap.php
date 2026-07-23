<?php

/**
 * PHPUnit bootstrap for cinghie/yii2-admin-lte.
 */

$packageRoot = dirname(__DIR__);

$autoloadCandidates = [
	$packageRoot . '/vendor/autoload.php',
	dirname($packageRoot, 3) . '/autoload.php', // .../vendor/cinghie/yii2-admin-lte → .../vendor/autoload.php
	dirname($packageRoot, 2) . '/autoload.php',
];

$autoload = null;
foreach ($autoloadCandidates as $candidate) {
	if (is_file($candidate)) {
		$autoload = $candidate;
		break;
	}
}

if ($autoload === null) {
	fwrite(STDERR, "Composer autoload not found. Run composer install in the app or package.\n");
	exit(1);
}

require $autoload;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');
defined('YII_ENV_TEST') or define('YII_ENV_TEST', true);
defined('YII_ENV_PROD') or define('YII_ENV_PROD', false);
defined('YII_ENV_DEV') or define('YII_ENV_DEV', false);

require_once dirname($autoload) . '/yiisoft/yii2/Yii.php';

// Package tests namespace when running against the app's Composer autoload
spl_autoload_register(static function ($class) {
	$prefix = 'cinghie\\adminlte\\tests\\';
	if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
		return;
	}
	$relative = substr($class, strlen($prefix));
	$file = dirname(__DIR__) . '/tests/' . str_replace('\\', '/', $relative) . '.php';
	if (is_file($file)) {
		require $file;
	}
});
