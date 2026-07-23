<?php

namespace cinghie\adminlte\tests\unit;

use Yii;
use cinghie\adminlte\tests\TestCase;
use cinghie\adminlte\widgets\Alert;
use cinghie\adminlte\widgets\Footer;
use cinghie\adminlte\widgets\NavbarLogo;
use cinghie\adminlte\widgets\SidebarSearch;
use cinghie\adminlte\widgets\SidebarToggle;
use cinghie\adminlte\widgets\Simplebox1;
use cinghie\adminlte\widgets\Simplebox3;

/**
 * Smoke tests for smaller AdminLTE widgets.
 */
class WidgetsSmokeTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		$this->mockApplication();
	}

	public function testAlertRendersFlashMessages(): void
	{
		Yii::$app->session->setFlash('success', 'Saved OK');
		Yii::$app->session->setFlash('error', 'Boom');
		$html = Alert::widget();
		$this->assertStringContainsString('Saved OK', $html);
		$this->assertStringContainsString('Boom', $html);
		$this->assertStringContainsString('alert-success', $html);
		$this->assertStringContainsString('alert-danger', $html);
	}

	public function testSimplebox3Renders(): void
	{
		$html = Simplebox3::widget([
			'bgclass' => 'bg-green',
			'title' => '42',
			'subtitle' => 'Orders',
			'link' => '/orders',
		]);
		$this->assertStringContainsString('bg-green', $html);
		$this->assertStringContainsString('42', $html);
		$this->assertStringContainsString('Orders', $html);
		$this->assertStringContainsString('/orders', $html);
	}

	public function testSimplebox1Renders(): void
	{
		$html = Simplebox1::widget([
			'title' => 'Messages',
			'subtitle' => '10',
		]);
		$this->assertStringContainsString('info-box', $html);
		$this->assertStringContainsString('Messages', $html);
	}

	public function testFooterAndNavbarLogo(): void
	{
		$footer = Footer::widget([
			'copyright_text' => 'Acme',
			'copyright_link' => 'https://example.com',
			'version' => '9.9.9',
		]);
		$this->assertStringContainsString('Acme', $footer);
		$this->assertStringContainsString('9.9.9', $footer);

		$logo = NavbarLogo::widget([
			'logo_lg' => '<b>Co</b>App',
			'logo_mini' => '<b>C</b>',
		]);
		$this->assertStringContainsString('logo-lg', $logo);
		$this->assertStringContainsString('Co', $logo);
	}

	public function testSidebarToggleAndSearch(): void
	{
		$toggle = SidebarToggle::widget();
		$this->assertStringContainsString('sidebar-toggle', $toggle);
		$this->assertStringContainsString('push-menu', $toggle);

		$search = SidebarSearch::widget(['placeholder' => 'Find']);
		$this->assertStringContainsString('Find', $search);
		$this->assertStringContainsString('sidebar-form', $search);
	}
}
