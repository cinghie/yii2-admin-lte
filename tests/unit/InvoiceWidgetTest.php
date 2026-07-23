<?php

namespace cinghie\adminlte\tests\unit;

use Yii;
use cinghie\adminlte\tests\TestCase;
use cinghie\adminlte\widgets\Invoice;
use yii\helpers\Html;

/**
 * AdminLTE 2 Invoice widget (aligned with adminlte3 API).
 */
class InvoiceWidgetTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		$this->mockApplication();
	}

	public function testRendersWithoutDemoDefaults(): void
	{
		$html = Invoice::widget([
			'companyName' => 'Test Co',
			'invoiceNumber' => 'INV-1',
			'invoiceToName' => 'Client',
			'invoiceToSdi' => 'ABCDEFG',
			'invoiceToPec' => 'client@pec.example',
			'invoiceToVatCode' => 'IT12345678901',
			'invoicePaymentMethod' => 'Bonifico',
			'invoicePaymentMethodCode' => 'MP05',
			'invoiceType' => 'TD01',
			'invoiceSubtotal' => '10.00',
			'invoiceTax' => '2.00',
			'invoiceTotal' => '12.00',
			'invoiceItems' => [],
			'showActions' => true,
			'printUrl' => 'javascript:window.print();',
		]);

		$this->assertStringContainsString('cinghie-invoice', $html);
		$this->assertStringContainsString('Test Co', $html);
		$this->assertStringContainsString('INV-1', $html);
		$this->assertStringContainsString('12.00', $html);
		$this->assertStringContainsString('Bonifico', $html);
		$this->assertStringContainsString('ABCDEFG', $html);
		$this->assertStringContainsString('client@pec.example', $html);
		$this->assertStringContainsString('IT12345678901', $html);
		$this->assertStringContainsString('MP05', $html);
		$this->assertStringContainsString('TD01', $html);
		$this->assertStringContainsString('col-xs-12', $html);
		$this->assertStringNotContainsString('Call of Duty', $html);
		$this->assertStringNotContainsString('target="_blank"', $html);
	}

	public function testEncodesXssInTextFields(): void
	{
		$html = Invoice::widget([
			'companyName' => '<script>alert(1)</script>',
			'invoiceToName' => '<img src=x onerror=alert(1)>',
			'invoiceNotes' => '<b>note</b>',
			'invoiceItems' => [
				['product' => '<script>x</script>', 'quantity' => 1, 'subtotal' => '1'],
			],
			'showActions' => false,
		]);

		$this->assertStringNotContainsString('<script>', $html);
		$this->assertStringContainsString(Html::encode('<script>alert(1)</script>'), $html);
		$this->assertStringContainsString(Html::encode('<b>note</b>'), $html);
	}

	public function testNormalizeItemAliases(): void
	{
		$row = Invoice::normalizeItem([
			'description' => 'Fallback product',
			'detail' => 'Line detail',
			'unit_price' => '9.99',
			'qty' => 2,
			'amount' => '19.98',
			'serial' => 'S1',
		]);

		$this->assertSame('Fallback product', $row['product']);
		$this->assertSame('Line detail', $row['description']);
		$this->assertSame('9.99', $row['price']);
		$this->assertSame('2', $row['qty']);
		$this->assertSame('19.98', $row['subtotal']);
		$this->assertSame('S1', $row['serial']);
	}

	public function testNormalizeItemPrefersProductKey(): void
	{
		$row = Invoice::normalizeItem([
			'product' => 'SKU name',
			'description' => 'Shown as description',
			'product_price' => '5',
			'quantity' => 1,
			'subtotal' => '5',
		]);
		$this->assertSame('SKU name', $row['product']);
		$this->assertSame('Shown as description', $row['description']);
	}

	public function testRejectsUnsafeCompanyLogoHtml(): void
	{
		$html = Invoice::widget([
			'companyName' => 'Safe',
			'companyLogo' => '<script>alert(1)</script>',
			'showActions' => false,
		]);
		$this->assertStringNotContainsString('<script>', $html);
		$this->assertStringContainsString('fa fa-globe', $html);
	}

	public function testAllowsSafeIconLogo(): void
	{
		$html = Invoice::widget([
			'companyName' => 'Safe',
			'companyLogo' => '<i class="fa fa-building"></i>',
			'showActions' => false,
		]);
		$this->assertStringContainsString('fa fa-building', $html);
	}

	public function testPdfActionUsesTargetBlank(): void
	{
		$html = Invoice::widget([
			'companyName' => 'Co',
			'showActions' => true,
			'pdfUrl' => ['/invoice/pdf', 'id' => 1],
		]);
		$this->assertStringContainsString('target="_blank"', $html);
		$this->assertStringContainsString('rel="noopener"', $html);
	}

	public function testEmptyItemsShowsPlaceholder(): void
	{
		$html = Invoice::widget([
			'companyName' => 'Co',
			'invoiceItems' => [],
			'showActions' => false,
		]);
		$this->assertStringContainsString(Yii::t('traits', 'No line items'), $html);
	}

	public function testPaymentMethodAppearsOnceInMeta(): void
	{
		$html = Invoice::widget([
			'companyName' => 'Co',
			'invoicePaymentMethod' => 'Bonifico',
			'invoicePaymentMethodCode' => 'MP05',
			'invoiceNotes' => 'Pay soon',
			'invoiceTotal' => '10',
			'showActions' => false,
		]);
		$this->assertSame(1, substr_count($html, 'Bonifico'));
		$this->assertStringContainsString('Pay soon', $html);
	}

	public function testMaliciousPrintUrlIsReplaced(): void
	{
		$html = Invoice::widget([
			'companyName' => 'Co',
			'showActions' => true,
			'printUrl' => 'javascript:alert(1)',
		]);
		$this->assertStringContainsString('javascript:window.print();', $html);
		$this->assertStringNotContainsString('alert(1)', $html);
	}

	public function testMailtoStripsControlChars(): void
	{
		$html = Invoice::widget([
			'companyName' => 'Co',
			'invoiceToEmail' => "evil@example.com\" onclick=\"alert(1)",
			'showActions' => false,
		]);
		$this->assertMatchesRegularExpression('/href="mailto:evil@example\.com"/', $html);
		$this->assertDoesNotMatchRegularExpression('/href="[^"]*onclick/i', $html);
		$this->assertStringContainsString('evil@example.com', $html);
	}

	public function testMaliciousPdfUrlIsDropped(): void
	{
		$html = Invoice::widget([
			'companyName' => 'Co',
			'showActions' => true,
			'pdfUrl' => 'javascript:alert(1)',
		]);
		$this->assertStringNotContainsString('Generate PDF', $html);
		$this->assertStringNotContainsString('alert(1)', $html);
	}
}
