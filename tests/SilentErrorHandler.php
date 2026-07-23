<?php

namespace cinghie\adminlte\tests;

use yii\web\ErrorHandler;

/**
 * ErrorHandler that does not register PHP handlers (keeps PHPUnit happy).
 */
class SilentErrorHandler extends ErrorHandler
{
	public function register()
	{
		// no-op
	}
}
