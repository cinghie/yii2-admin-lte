<?php

namespace cinghie\adminlte\tests\unit;

use Yii;
use cinghie\adminlte\tests\TestCase;
use cinghie\adminlte\tests\TestSession;
use cinghie\adminlte\widgets\Alert;
use cinghie\adminlte\widgets\Footer;
use cinghie\adminlte\widgets\MailboxRead;
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
		$session = Yii::$app->get('session');
		$this->assertInstanceOf(TestSession::class, $session);
		$session->setFlash('success', 'Saved OK');
		$session->setFlash('error', 'Boom');
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

	public function testMailboxReadEncodesBodyAndAttachmentIconByDefault(): void
	{
		$attachment = new class {
			public $fileUrl = '/document.pdf';
			public $filename = 'document.pdf';

			public function getAttachmentTypeIcon(): string
			{
				return '<img src=x onerror=alert(1)>';
			}

			public function formatSize(): string
			{
				return '1 KB';
			}
		};

		$html = MailboxRead::widget([
			'mailBody' => '<script>alert(1)</script>',
			'mailAttachments' => [$attachment],
		]);

		$this->assertStringNotContainsString('<script>', $html);
		$this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;', $html);
		$this->assertStringNotContainsString('<img src=x onerror=alert(1)>', $html);
		$this->assertStringContainsString('&lt;img src=x onerror=alert(1)&gt;', $html);
	}

	public function testMailboxReadAllowsExplicitTrustedHtml(): void
	{
		$attachment = new class {
			public $fileUrl = '/document.pdf';
			public $filename = 'document.pdf';

			public function getAttachmentTypeIcon(): string
			{
				return '<i class="fa fa-file-pdf-o"></i>';
			}

			public function formatSize(): string
			{
				return '1 KB';
			}
		};

		$html = MailboxRead::widget([
			'mailBody' => '<p>Trusted body</p>',
			'mailAttachments' => [$attachment],
			'allowHtmlMailBody' => true,
			'allowHtmlAttachmentIcons' => true,
		]);

		$this->assertStringContainsString('<p>Trusted body</p>', $html);
		$this->assertStringContainsString('<i class="fa fa-file-pdf-o"></i>', $html);
	}
}
