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

namespace cinghie\adminlte\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * AdminLTE 2 / Bootstrap 3 invoice layout.
 *
 * Property surface matches {@see \cinghie\adminlte3\widgets\Invoice}.
 * Values are HTML-encoded; no demo data is injected when properties are empty.
 *
 * @see https://adminlte.io/themes/AdminLTE/pages/examples/invoice.html
 */
class Invoice extends Widget
{
	/** @var string */
	public $companyName = '';

	/** @var string Logo URL/path, or a safe &lt;i&gt; icon HTML snippet */
	public $companyLogo = '';

	/** @var string */
	public $invoiceDate = '';

	/** @var string */
	public $invoiceFromName = '';

	/** @var string */
	public $invoiceFromAddress = '';

	/** @var string */
	public $invoiceFromAddressInfo = '';

	/** @var string */
	public $invoiceFromPhone = '';

	/** @var string */
	public $invoiceFromEmail = '';

	/** @var string VAT / Partita IVA (From) */
	public $invoiceFromVatCode = '';

	/** @var string Tax code / Codice fiscale (From) */
	public $invoiceFromTaxCode = '';

	/** @var string Codice Destinatario SDI (From) */
	public $invoiceFromSdi = '';

	/** @var string PEC (From) */
	public $invoiceFromPec = '';

	/** @var string */
	public $invoiceFromWebsite = '';

	/** @var string */
	public $invoiceFromFax = '';

	/** @var string */
	public $invoiceToName = '';

	/** @var string */
	public $invoiceToAddress = '';

	/** @var string */
	public $invoiceToAddressInfo = '';

	/** @var string */
	public $invoiceToPhone = '';

	/** @var string */
	public $invoiceToEmail = '';

	/** @var string */
	public $invoiceToMobile = '';

	/** @var string */
	public $invoiceToFax = '';

	/** @var string VAT / Partita IVA (To) */
	public $invoiceToVatCode = '';

	/** @var string Tax code / Codice fiscale (To) */
	public $invoiceToTaxCode = '';

	/** @var string Codice Destinatario SDI (To) */
	public $invoiceToSdi = '';

	/** @var string PEC (To) */
	public $invoiceToPec = '';

	/** @var string */
	public $invoiceToWebsite = '';

	/** @var string raw invoice number / code (label applied in view) */
	public $invoiceNumber = '';

	/** @var string */
	public $invoiceOrderID = '';

	/** @var string document type (e.g. TD01) */
	public $invoiceType = '';

	/** @var string payment due date */
	public $invoicePaymentDue = '';

	/** @var string paid-on date (shown as Paid, not Due) */
	public $invoicePaid = '';

	/** @var string sent-on date */
	public $invoiceSent = '';

	/** @var string account / customer reference */
	public $invoiceAccount = '';

	/**
	 * Line items. Supported keys (any subset):
	 * product|description, serial, detail, product_price|price|unit_price,
	 * quantity|qty, subtotal|amount
	 *
	 * @var array
	 */
	public $invoiceItems = [];

	/** @var string formatted subtotal */
	public $invoiceSubtotal = '';

	/** @var string formatted tax */
	public $invoiceTax = '';

	/** @var string optional tax rate label, e.g. "22%" */
	public $invoiceTaxLabel = '';

	/** @var string formatted shipping (optional) */
	public $invoiceShipping = '';

	/** @var string formatted total */
	public $invoiceTotal = '';

	/** @var string notes / payment terms (plain text, encoded) */
	public $invoiceNotes = '';

	/** @var string payment method label */
	public $invoicePaymentMethod = '';

	/** @var string payment method code (e.g. MP05) */
	public $invoicePaymentMethodCode = '';

	/** @var bool show print / PDF action row */
	public $showActions = true;

	/** @var string|null print URL (defaults to javascript:window.print()) */
	public $printUrl;

	/** @var string|null optional PDF download URL */
	public $pdfUrl;

	/**
	 * {@inheritdoc}
	 */
	public function run()
	{
		$this->registerInvoiceCss();

		$html = Html::beginTag('section', ['class' => 'invoice cinghie-invoice']);
		$html .= $this->renderTitleRow();
		$html .= $this->renderInfoRow();
		$html .= $this->renderItemsTable();
		$html .= $this->renderTotalsRow();
		if ($this->showActions) {
			$html .= $this->renderActionsRow();
		}
		$html .= Html::endTag('section');

		return $html;
	}

	/**
	 * Widget-scoped tweaks on top of AdminLTE 2 invoice styles.
	 */
	protected function registerInvoiceCss()
	{
		if (!Yii::$app->has('view')) {
			return;
		}

		$css = <<<'CSS'
.cinghie-invoice.invoice {
	padding: 15px;
}
.cinghie-invoice .invoice-extra {
	color: #444;
}
.cinghie-invoice .invoice-notes {
	margin-top: 10px;
	margin-bottom: 0;
	padding: 10px 12px;
	background-color: #f7f7f7;
	border: 1px solid #eee;
	border-radius: 3px;
	color: #777;
}
.cinghie-invoice .invoice-items .table {
	margin-bottom: 0;
}
@media print {
	.cinghie-invoice .no-print {
		display: none !important;
	}
}
CSS;
		Yii::$app->view->registerCss($css, [], 'cinghie-adminlte-invoice');
	}

	/**
	 * @return string
	 */
	protected function renderTitleRow()
	{
		$logo = $this->renderLogo();
		$date = '';
		if ($this->isFilled($this->invoiceDate)) {
			$date = ' <small class="pull-right">'
				. Html::encode(Yii::t('traits', 'Date') . ': ' . $this->invoiceDate)
				. '</small>';
		}

		return '<div class="row"><div class="col-xs-12"><h2 class="page-header">'
			. $logo . Html::encode((string) $this->companyName)
			. $date
			. '</h2></div></div>';
	}

	/**
	 * @return string
	 */
	protected function renderLogo()
	{
		if ($this->companyLogo === null || $this->companyLogo === '') {
			return '<i class="fa fa-globe"></i> ';
		}
		// Allow only a single icon tag (FA) — not arbitrary HTML.
		if (is_string($this->companyLogo)
			&& preg_match('#^\s*<i\s+class="[^"]+"\s*>\s*</i>\s*$#i', $this->companyLogo)
		) {
			return trim($this->companyLogo) . ' ';
		}
		if (is_string($this->companyLogo) && strpos($this->companyLogo, '<') !== false) {
			return '<i class="fa fa-globe"></i> ';
		}
		if (is_string($this->companyLogo) && preg_match('#^(javascript|data)\s*:#i', ltrim($this->companyLogo))) {
			return '<i class="fa fa-globe"></i> ';
		}

		return Html::img($this->companyLogo, [
			'alt' => '',
			'style' => 'max-height:40px;margin-right:.5rem;',
		]) . ' ';
	}

	/**
	 * @return string
	 */
	protected function renderInfoRow()
	{
		return '<div class="row invoice-info">'
			. '<div class="col-sm-4 invoice-col">'
			. Html::encode(Yii::t('traits', 'From'))
			. '<address>'
			. $this->renderAddressBlock([
				'name' => $this->invoiceFromName,
				'address' => $this->invoiceFromAddress,
				'addressInfo' => $this->invoiceFromAddressInfo,
				'phone' => $this->invoiceFromPhone,
				'fax' => $this->invoiceFromFax,
				'email' => $this->invoiceFromEmail,
				'vatCode' => $this->invoiceFromVatCode,
				'taxCode' => $this->invoiceFromTaxCode,
				'sdi' => $this->invoiceFromSdi,
				'pec' => $this->invoiceFromPec,
				'website' => $this->invoiceFromWebsite,
			])
			. '</address></div>'
			. '<div class="col-sm-4 invoice-col">'
			. Html::encode(Yii::t('traits', 'To'))
			. '<address>'
			. $this->renderAddressBlock([
				'name' => $this->invoiceToName,
				'address' => $this->invoiceToAddress,
				'addressInfo' => $this->invoiceToAddressInfo,
				'phone' => $this->invoiceToPhone,
				'mobile' => $this->invoiceToMobile,
				'fax' => $this->invoiceToFax,
				'email' => $this->invoiceToEmail,
				'vatCode' => $this->invoiceToVatCode,
				'taxCode' => $this->invoiceToTaxCode,
				'sdi' => $this->invoiceToSdi,
				'pec' => $this->invoiceToPec,
				'website' => $this->invoiceToWebsite,
			])
			. '</address></div>'
			. '<div class="col-sm-4 invoice-col">'
			. $this->renderMetaBlock()
			. '</div></div>';
	}

	/**
	 * @param mixed $value
	 * @return bool
	 */
	protected function isFilled($value)
	{
		return $value !== null && $value !== '';
	}

	/**
	 * @param string $label
	 * @param string $value
	 * @param string|null $href
	 * @return string
	 */
	protected function extraLine($label, $value, $href = null)
	{
		$labelHtml = '<b>' . Html::encode($label) . ':</b> ';
		if ($href) {
			return '<span class="invoice-extra">' . $labelHtml
				. Html::a(Html::encode($value), $href) . '</span>';
		}

		return '<span class="invoice-extra">' . $labelHtml . Html::encode($value) . '</span>';
	}

	/**
	 * @param string $website
	 * @return string|null
	 */
	protected function normalizeWebsiteHref($website)
	{
		$website = trim((string) $website);
		if ($website === '') {
			return null;
		}
		if (preg_match('#^(javascript|data)\s*:#i', $website)) {
			return null;
		}
		if (preg_match('#^https?://#i', $website)) {
			return $website;
		}

		return 'https://' . $website;
	}

	/**
	 * Build a safe mailto: href or null (plain text only).
	 *
	 * @param string $email
	 * @return string|null
	 */
	protected function mailtoHref($email)
	{
		$sanitized = $this->sanitizeEmail($email);

		return $sanitized !== null ? 'mailto:' . $sanitized : null;
	}

	/**
	 * Extract a simple safe email address from untrusted input.
	 *
	 * @param string $email
	 * @return string|null
	 */
	protected function sanitizeEmail($email)
	{
		$email = trim((string) $email);
		$email = preg_replace('/[^a-zA-Z0-9._%+\-@]/', '', $email);
		if ($email === null || $email === '' || substr_count($email, '@') !== 1) {
			return null;
		}

		// Known / common TLDs — avoids treating "comonclick…" as a TLD
		$tld = 'com|org|net|edu|gov|mil|int|info|biz|name|pro|io|co|it|eu|uk|de|fr|es|nl|ch|at|'
			. 'be|pt|pl|cz|sk|si|hr|ro|bg|gr|se|no|dk|fi|ie|us|ca|au|nz|jp|cn|br|ar|mx|example|test|local|pec';
		$pattern = '/^[a-zA-Z0-9._%+\-]+@(?:[a-zA-Z0-9\-]+\.)+(?:' . $tld . ')$/i';

		for ($len = strlen($email); $len >= 5; $len--) {
			$candidate = substr($email, 0, $len);
			if (preg_match($pattern, $candidate) && filter_var($candidate, FILTER_VALIDATE_EMAIL)) {
				return $candidate;
			}
		}

		return null;
	}

	/**
	 * @param array $party
	 * @return string
	 */
	protected function renderAddressBlock(array $party)
	{
		$parts = [];
		$name = $party['name'] ?? '';
		$address = $party['address'] ?? '';
		$addressInfo = $party['addressInfo'] ?? '';
		$phone = $party['phone'] ?? '';
		$mobile = $party['mobile'] ?? '';
		$fax = $party['fax'] ?? '';
		$email = $party['email'] ?? '';
		$vatCode = $party['vatCode'] ?? '';
		$taxCode = $party['taxCode'] ?? '';
		$sdi = $party['sdi'] ?? '';
		$pec = $party['pec'] ?? '';
		$website = $party['website'] ?? '';

		if ($this->isFilled($name)) {
			$parts[] = '<strong>' . Html::encode($name) . '</strong>';
		}
		if ($this->isFilled($address)) {
			$parts[] = Html::encode($address);
		}
		if ($this->isFilled($addressInfo)) {
			$parts[] = Html::encode($addressInfo);
		}
		if ($this->isFilled($vatCode)) {
			$parts[] = $this->extraLine(Yii::t('traits', 'Vat Code'), (string) $vatCode);
		}
		if ($this->isFilled($taxCode)) {
			$parts[] = $this->extraLine(Yii::t('traits', 'Tax Code'), (string) $taxCode);
		}
		if ($this->isFilled($sdi)) {
			$parts[] = $this->extraLine(Yii::t('traits', 'SDI'), (string) $sdi);
		}
		if ($this->isFilled($pec)) {
			$safePec = $this->sanitizeEmail((string) $pec);
			$parts[] = $this->extraLine(
				Yii::t('traits', 'PEC'),
				$safePec !== null ? $safePec : (string) $pec,
				$safePec !== null ? 'mailto:' . $safePec : null
			);
		}
		if ($this->isFilled($phone)) {
			$parts[] = $this->extraLine(Yii::t('traits', 'Phone'), (string) $phone);
		}
		if ($this->isFilled($mobile)) {
			$parts[] = $this->extraLine(Yii::t('traits', 'Mobile'), (string) $mobile);
		}
		if ($this->isFilled($fax)) {
			$parts[] = $this->extraLine(Yii::t('traits', 'Fax'), (string) $fax);
		}
		if ($this->isFilled($email)) {
			$safeEmail = $this->sanitizeEmail((string) $email);
			$parts[] = $this->extraLine(
				Yii::t('traits', 'Email'),
				$safeEmail !== null ? $safeEmail : (string) $email,
				$safeEmail !== null ? 'mailto:' . $safeEmail : null
			);
		}
		if ($this->isFilled($website)) {
			$href = $this->normalizeWebsiteHref((string) $website);
			$parts[] = $this->extraLine(Yii::t('traits', 'Website'), (string) $website, $href);
		}

		return implode('<br>', $parts);
	}

	/**
	 * @return string
	 */
	protected function renderMetaBlock()
	{
		$lines = [];
		if ($this->isFilled($this->invoiceNumber)) {
			$lines[] = '<b>' . Html::encode(Yii::t('traits', 'Invoice') . ' #' . $this->invoiceNumber) . '</b>';
			$lines[] = '';
		}
		if ($this->isFilled($this->invoiceType)) {
			$lines[] = '<b>' . Html::encode(Yii::t('traits', 'Type')) . ':</b> '
				. Html::encode($this->invoiceType);
		}
		if ($this->isFilled($this->invoiceOrderID)) {
			$lines[] = '<b>' . Html::encode(Yii::t('traits', 'Order ID')) . ':</b> '
				. Html::encode($this->invoiceOrderID);
		}
		if ($this->isFilled($this->invoicePaymentDue)) {
			$lines[] = '<b>' . Html::encode(Yii::t('traits', 'Payment Due')) . ':</b> '
				. Html::encode($this->invoicePaymentDue);
		}
		if ($this->isFilled($this->invoiceSent)) {
			$lines[] = '<b>' . Html::encode(Yii::t('crm', 'Invoice sent')) . ':</b> '
				. Html::encode($this->invoiceSent);
		}
		if ($this->isFilled($this->invoicePaid)) {
			$lines[] = '<b>' . Html::encode(Yii::t('traits', 'Paid')) . ':</b> '
				. Html::encode($this->invoicePaid);
		}
		if ($this->isFilled($this->invoiceAccount)) {
			$lines[] = '<b>' . Html::encode(Yii::t('traits', 'Account')) . ':</b> '
				. Html::encode($this->invoiceAccount);
		}
		if ($this->isFilled($this->invoicePaymentMethod)) {
			$method = $this->invoicePaymentMethod;
			if ($this->isFilled($this->invoicePaymentMethodCode)) {
				$method .= ' (' . $this->invoicePaymentMethodCode . ')';
			}
			$lines[] = '<b>' . Html::encode(Yii::t('traits', 'Payment Method')) . ':</b> '
				. Html::encode($method);
		} elseif ($this->isFilled($this->invoicePaymentMethodCode)) {
			$lines[] = '<b>' . Html::encode(Yii::t('traits', 'Payment Method')) . ':</b> '
				. Html::encode($this->invoicePaymentMethodCode);
		}

		return implode('<br>', $lines);
	}

	/**
	 * Normalize a line-item row to display columns.
	 *
	 * @param array $item
	 * @return array{product:string,serial:string,description:string,price:string,qty:string,subtotal:string}
	 */
	public static function normalizeItem(array $item)
	{
		$hasProduct = array_key_exists('product', $item) && $item['product'] !== '' && $item['product'] !== null;
		$product = $hasProduct
			? (string) $item['product']
			: (string) ($item['description'] ?? '');
		$description = $hasProduct
			? (string) ($item['detail'] ?? $item['description'] ?? '')
			: (string) ($item['detail'] ?? '');

		return [
			'product' => $product,
			'serial' => (string) ($item['serial'] ?? ''),
			'description' => $description,
			'price' => (string) ($item['product_price'] ?? $item['unit_price'] ?? $item['price'] ?? ''),
			'qty' => (string) ($item['quantity'] ?? $item['qty'] ?? ''),
			'subtotal' => (string) ($item['subtotal'] ?? $item['amount'] ?? ''),
		];
	}

	/**
	 * @return string
	 */
	protected function renderItemsTable()
	{
		$html = '<div class="row"><div class="col-xs-12 table-responsive invoice-items">'
			. '<table class="table table-striped">'
			. '<thead><tr>'
			. '<th class="text-center">' . Html::encode(Yii::t('traits', 'Product')) . '</th>'
			. '<th class="text-center">' . Html::encode(Yii::t('traits', 'Serial')) . '</th>'
			. '<th class="text-center">' . Html::encode(Yii::t('traits', 'Description')) . '</th>'
			. '<th class="text-center">' . Html::encode(Yii::t('traits', 'Unit Price')) . '</th>'
			. '<th class="text-center">' . Html::encode(Yii::t('traits', 'Quantity')) . '</th>'
			. '<th class="text-center">' . Html::encode(Yii::t('traits', 'Subtotal')) . '</th>'
			. '</tr></thead><tbody>';

		$items = is_array($this->invoiceItems) ? $this->invoiceItems : [];
		if ($items === []) {
			$html .= '<tr><td colspan="6" class="text-center text-muted">'
				. Html::encode(Yii::t('traits', 'No line items'))
				. '</td></tr>';
		} else {
			foreach ($items as $item) {
				if (!is_array($item)) {
					continue;
				}
				$row = static::normalizeItem($item);
				$html .= '<tr>'
					. '<td class="text-center">' . Html::encode($row['product']) . '</td>'
					. '<td class="text-center">' . Html::encode($row['serial']) . '</td>'
					. '<td class="text-center">' . Html::encode($row['description']) . '</td>'
					. '<td class="text-center">' . Html::encode($row['price']) . '</td>'
					. '<td class="text-center">' . Html::encode($row['qty']) . '</td>'
					. '<td class="text-center">' . Html::encode($row['subtotal']) . '</td>'
					. '</tr>';
			}
		}

		return $html . '</tbody></table></div></div>';
	}

	/**
	 * @return string
	 */
	protected function renderTotalsRow()
	{
		// Payment method stays in the meta column only (avoid duplicate labels).
		$left = '';
		if ($this->isFilled($this->invoiceNotes)) {
			$left .= '<p class="text-muted invoice-notes">'
				. nl2br(Html::encode($this->invoiceNotes), false)
				. '</p>';
		}

		$amountDueLabel = Yii::t('traits', 'Amount Due');
		if ($this->isFilled($this->invoicePaymentDue)) {
			$amountDueLabel .= ' ' . $this->invoicePaymentDue;
		} elseif ($this->isFilled($this->invoicePaid)) {
			$amountDueLabel = Yii::t('traits', 'Paid') . ' ' . $this->invoicePaid;
		}

		$taxLabel = Html::encode(Yii::t('traits', 'Tax'));
		if ($this->isFilled($this->invoiceTaxLabel)) {
			$taxLabel .= ' (' . Html::encode($this->invoiceTaxLabel) . ')';
		}

		$rows = '';
		if ($this->isFilled($this->invoiceSubtotal)) {
			$rows .= '<tr><th style="width:50%">' . Html::encode(Yii::t('traits', 'Subtotal')) . ':</th>'
				. '<td>' . Html::encode($this->invoiceSubtotal) . '</td></tr>';
		}
		if ($this->isFilled($this->invoiceTax)) {
			$rows .= '<tr><th>' . $taxLabel . '</th>'
				. '<td>' . Html::encode($this->invoiceTax) . '</td></tr>';
		}
		if ($this->isFilled($this->invoiceShipping)) {
			$rows .= '<tr><th>' . Html::encode(Yii::t('traits', 'Shipping')) . ':</th>'
				. '<td>' . Html::encode($this->invoiceShipping) . '</td></tr>';
		}
		if ($this->isFilled($this->invoiceTotal)) {
			$rows .= '<tr><th>' . Html::encode(Yii::t('traits', 'Total')) . ':</th>'
				. '<td>' . Html::encode($this->invoiceTotal) . '</td></tr>';
		}

		$right = '';
		if ($rows !== '') {
			$right .= '<p class="lead">' . Html::encode($amountDueLabel) . '</p>'
				. '<div class="table-responsive"><table class="table">' . $rows . '</table></div>';
		}

		return '<div class="row">'
			. '<div class="col-xs-6">' . $left . '</div>'
			. '<div class="col-xs-6">' . $right . '</div>'
			. '</div>';
	}

	/**
	 * @return string
	 */
	protected function renderActionsRow()
	{
		$printUrl = $this->resolvePrintUrl();
		$isJsPrint = strncmp($printUrl, 'javascript:', 11) === 0;
		$printOptions = ['class' => 'btn btn-default'];
		if (!$isJsPrint) {
			$printOptions['target'] = '_blank';
			$printOptions['rel'] = 'noopener';
		}

		$html = '<div class="row no-print"><div class="col-xs-12">'
			. Html::a(
				'<i class="fa fa-print"></i> ' . Html::encode(Yii::t('traits', 'Print')),
				$printUrl,
				$printOptions
			);

		$pdfHref = $this->resolvePdfUrl();
		if ($pdfHref !== null) {
			$html .= ' ' . Html::a(
				'<i class="fa fa-download"></i> ' . Html::encode(Yii::t('traits', 'Generate PDF')),
				$pdfHref,
				[
					'class' => 'btn btn-primary pull-right',
					'style' => 'margin-right: 5px;',
					'target' => '_blank',
					'rel' => 'noopener',
				]
			);
		}

		return $html . '</div></div>';
	}

	/**
	 * Allow only window.print() for javascript: print URLs.
	 *
	 * @return string
	 */
	protected function resolvePrintUrl()
	{
		$url = $this->printUrl;
		if ($url === null || $url === '') {
			return 'javascript:window.print();';
		}
		if (!is_string($url)) {
			return Url::to($url);
		}
		if (preg_match('#^javascript\s*:#i', ltrim($url))) {
			if (preg_match('#^javascript:\s*window\.print\s*\(\s*\)\s*;?\s*$#i', trim($url))) {
				return 'javascript:window.print();';
			}

			return 'javascript:window.print();';
		}
		if (preg_match('#^data\s*:#i', ltrim($url))) {
			return 'javascript:window.print();';
		}

		return $url;
	}

	/**
	 * Resolve PDF download URL; block javascript:/data: schemes.
	 *
	 * @return string|null
	 */
	protected function resolvePdfUrl()
	{
		if ($this->pdfUrl === null || $this->pdfUrl === '' || $this->pdfUrl === false) {
			return null;
		}
		if (is_string($this->pdfUrl) && preg_match('#^(javascript|data)\s*:#i', ltrim($this->pdfUrl))) {
			return null;
		}
		$href = Url::to($this->pdfUrl);
		if (is_string($href) && preg_match('#^(javascript|data)\s*:#i', ltrim($href))) {
			return null;
		}

		return $href;
	}
}
