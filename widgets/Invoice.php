<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-admin-lte
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-AdminLTE
 * @version 1.5.4
 */

namespace cinghie\adminlte\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;

/**
 * Class Invoice
 */
class Invoice extends Widget
{
	/**
     * @var string
     */
	public $companyName;

	/**
     * @var string
     */
	public $companyLogo;

	/**
     * @var string
     */
	public $invoiceDate;

	/**
     * @var string
     */
	public $invoiceFromName;

	/**
     * @var string
     */
	public $invoiceFromAddress;

	/**
     * @var string
     */
	public $invoiceFromAddressInfo;

	/**
     * @var string
     */
	public $invoiceFromPhone;

	/**
     * @var string
     */
	public $invoiceFromEmail;

	/**
     * @var string
     */
	public $invoiceToName;

	/**
     * @var string
     */
	public $invoiceToAddress;

	/**
     * @var string
     */
	public $invoiceToAddressInfo;

	/**
     * @var string
     */
	public $invoiceToPhone;

	/**
     * @var string
     */
	public $invoiceToEmail;

	/**
     * @var string
     */
	public $invoiceNumber;

	/**
     * @var string
     */
	public $invoiceOrderID;

	/**
     * @var string
     */
	public $invoiceAmountDue;

	/**
     * @var string
     */
	public $invoicePaymentDue;

	/**
     * @var string
     */
	public $invoiceAccount;

	/**
     * @var array
     */
	public $invoiceItems;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->companyName === null) {
			$this->companyName = 'AdminLTE, Inc.';
		}

		if ($this->companyLogo === null) {
			$this->companyLogo = '<i class="fa fa-globe"></i> ';
		}

		if ($this->invoiceDate === null) {
			$this->invoiceDate = '2/10/2014';
		}

		if($this->invoiceFromName === null) {
			$this->invoiceFromName = 'Admin, Inc.';
		}

		if($this->invoiceFromAddress === null) {
			$this->invoiceFromAddress = '795 Folsom Ave, Suite 600';
		}

		if($this->invoiceFromAddressInfo === null) {
			$this->invoiceFromAddressInfo = 'San Francisco, CA 94107';
		}

		if($this->invoiceFromEmail) {
			$emailLink = Html::a($this->invoiceFromEmail, null, ['href' => 'mailto:'.$this->invoiceFromEmail]);
			$this->invoiceFromEmail = Yii::t('traits','Email').': '.$emailLink;
		} else {
			$this->invoiceFromEmail = '';
		}

		if($this->invoiceToName === null) {
			$this->invoiceToName = 'John Doe';
		}

		if($this->invoiceToAddress === null) {
			$this->invoiceToAddress = '795 Folsom Ave, Suite 600';
		}

		if($this->invoiceToAddressInfo === null) {
			$this->invoiceToAddressInfo = 'San Francisco, CA 94107';
		}

		if($this->invoiceToEmail) {
			$emailLink = Html::a($this->invoiceToEmail, null, ['href' => 'mailto:'.$this->invoiceToEmail]);
			$this->invoiceToEmail = Yii::t('traits','Email').': '.$emailLink;
		} else {
			$this->invoiceToEmail = '';
		}

		if($this->invoiceFromPhone) {
			$this->invoiceFromPhone = Yii::t('traits','Phone').': '.$this->invoiceFromPhone;
		}

		if($this->invoiceNumber) {
			$this->invoiceNumber = Yii::t('traits','Invoice').' #'.$this->invoiceNumber;
		}

		if($this->invoiceOrderID) {
			$this->invoiceOrderID = '<b>'.Yii::t('traits','Order ID').':</b> '.$this->invoiceOrderID;
		}

		if($this->invoicePaymentDue) {
			$this->invoiceAmountDue = Yii::t('traits','Amount Due').' '.$this->invoicePaymentDue;
		}

		if($this->invoicePaymentDue) {
			$this->invoicePaymentDue = '<b>'.Yii::t('traits','Payment Due').':</b> '.$this->invoicePaymentDue;
		}

		if($this->invoiceAccount) {
			$this->invoiceAccount = '<b>Account:</b> '.$this->invoiceAccount;
		}

		if($this->invoiceToPhone) {
			$this->invoiceToPhone = Yii::t('traits','Phone').': '.$this->invoiceToPhone;
		}

		if($this->invoiceItems === null)
		{
			$this->invoiceItems = [
				['quantity' => 2,'product'=>'Call of Duty','serial'=>'455-981-221','description'=>'El snort testosterone trophy driving gloves handsome','product_price'=>'$32.25','subtotal'=>'$64.50'],
				['quantity' => 1,'product'=>'Need for Speed IV','serial'=>'247-925-726','description'=>'Wes Anderson umami biodiesel','product_price'=>'$50.00','subtotal'=>'$50.00'],
				['quantity' => 2,'product'=>'Monsters DVD','serial'=>'735-845-642','description'=>'Terry Richardson helvetica tousled street art master','product_price'=>'$5.35','subtotal'=>'$10.70'],
				['quantity' => 1,'product'=>'Grown Ups Blue Ray','serial'=>'422-568-642','description'=>'Tousled lomo letterpress','product_price'=>'$25.99','subtotal'=>'$25.99'],
			];
		}

        parent::init();
	}

	/**
	 * @return string
	 */
	public function run()
	{
		$html = '<section class="invoice">';

		$html.= '<!-- title row -->
	      	<div class="row">
		        <div class="col-xs-12">
			    	<h2 class="page-header">
			        	'.$this->companyLogo.$this->companyName.'
			            <small class="pull-right">'.Yii::t('traits', 'Date').': '.$this->invoiceDate.'</small>
			        </h2>
		        </div><!-- /.col -->
	      	</div>';

		$html .= '<!-- info row -->
	        <div class="row invoice-info">
		        <div class="col-sm-4 invoice-col">
		        	'.Yii::t('traits','From').'
		          	<address>
			            <strong>'.$this->invoiceFromName.'</strong><br>
			            '.$this->invoiceFromAddress.'<br>
			            '.$this->invoiceFromAddressInfo.'<br>
			            '.$this->invoiceFromPhone.'<br>
			            '.$this->invoiceFromEmail.'
		          	</address>
		        </div><!-- /.col -->
		        <div class="col-sm-4 invoice-col">
		            '.Yii::t('traits','To').'
			        <address>
			            <strong>'.$this->invoiceToName.'</strong><br>
			            '.$this->invoiceToAddress.'<br>
			            '.$this->invoiceToAddressInfo.'<br>
			            '.$this->invoiceToPhone.'<br>
			            '.$this->invoiceToEmail.'
			        </address>
		        </div><!-- /.col -->
		        <div class="col-sm-4 invoice-col">
		        	<b>'.$this->invoiceNumber.'</b><br>
		          	<br>
		          	'.$this->invoiceOrderID.'<br>
		          	'.$this->invoicePaymentDue.'<br>
		          	'.$this->invoiceAccount.'
		        </div><!-- /.col -->
		    </div><!-- /.row -->';

		$html .= '<!-- Table row -->
		    <div class="row">
		        <div class="col-xs-12 table-responsive">
		        	<table class="table table-striped">
			            <thead>
				            <tr>
				            	<th class="text-center">'.Yii::t('traits','Product').'</th>
				            	<th class="text-center">'.Yii::t('traits','Serial').'</th>
				            	<th class="text-center">'.Yii::t('traits','Description').'</th>
				            	<th class="text-center">'.Yii::t('traits','Unit Price').'</th>
				            	<th class="text-center">'.Yii::t('traits','Quantity').'</th>
				            	<th class="text-center">'.Yii::t('traits','Subtotal').'</th>
				            </tr>
			            </thead>
			            <tbody>';

		foreach($this->invoiceItems as $item)
		{
			$html .= '<tr>
				          <td class="text-center">'.$item['product'].'</td>
				          <td class="text-center">'.$item['serial'].'</td>
				          <td class="text-center">'.$item['description'].'</td>
				          <td class="text-center">'.$item['product_price'].'</td>
				          <td class="text-center">'.$item['quantity'].'</td>
				          <td class="text-center">'.$item['subtotal'].'</td>
			</tr>';
		}

		$html .= '	            </tbody>
		        	</table>
		        </div><!-- /.col -->
		    </div><!-- /.row -->';

		$html .= '<!-- accepted payments column -->
		    <div class="row">
		        <div class="col-xs-6">
		        	<p class="lead">Payment Methods:</p>
		          	<img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/visa.png" alt="Visa">
		          	<img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/mastercard.png" alt="Mastercard">
		          	<img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/american-express.png" alt="American Express">
		          	<img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/paypal2.png" alt="Paypal">
		
		          	<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
		            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
		            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
		          	</p>
		        </div><!-- /.col -->
		        <div class="col-xs-6">
		          	<p class="lead">'.$this->invoiceAmountDue.'</p>
		
		          	<div class="table-responsive">
			            <table class="table">
			            	<tr>
			                	<th style="width:50%">'.Yii::t('traits','Subtotal').':</th>
			                	<td>$250.30</td>
			              	</tr>
			              	<tr>
			                	<th>'.Yii::t('traits','Tax').' (9.3%)</th>
			                	<td>$10.34</td>
			              	</tr>
			              	<tr>
			                	<th>'.Yii::t('traits','Shipping').':</th>
			                	<td>$5.80</td>
			              	</tr>
			              	<tr>
			                	<th>'.Yii::t('traits','Total').':</th>
			                	<td>$265.24</td>
			              	</tr>
			            </table>
		          	</div>
		        </div><!-- /.col -->
      		</div><!-- /.row -->';

		$html .= '<!-- this row will not appear when printing -->
	      	<div class="row no-print">
		        <div class="col-xs-12">
		          	<a href="" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
		          	<button type="button" class="btn btn-success pull-right">
		          		<i class="fa fa-credit-card"></i> Submit Payment
		   			</button>
		          	<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
		            	<i class="fa fa-download"></i> Generate PDF
		          	</button>
		        </div>
	      	</div>';

		$html .= '</section>';

		return $html;
	}

	/**
	 * @return string
	 */
	public function demo()
	{
		return '<section class="invoice">

	      	<!-- title row -->
	      	<div class="row">
		        <div class="col-xs-12">
			    	<h2 class="page-header">
			        	<i class="fa fa-globe"></i> AdminLTE, Inc.
            			<small class="pull-right">Date: 2/10/2014</small>
			        </h2>
		        </div><!-- /.col -->
	      	</div>
	      	
	      	<!-- info row -->
	        <div class="row invoice-info">
		        <div class="col-sm-4 invoice-col">
		        	From
		          	<address>
			            <strong>Admin, Inc.</strong><br>
			            795 Folsom Ave, Suite 600<br>
			            San Francisco, CA 94107<br>
			            Phone: (804) 123-5432<br>
			            Email: info@almasaeedstudio.com
		          	</address>
		        </div><!-- /.col -->
		        <div class="col-sm-4 invoice-col">
		            To
			        <address>
			            <strong>John Doe</strong><br>
			            795 Folsom Ave, Suite 600<br>
			            San Francisco, CA 94107<br>
			            Phone: (555) 539-1037<br>
			            Email: john.doe@example.com
			        </address>
		        </div><!-- /.col -->
		        <div class="col-sm-4 invoice-col">
		        	<b>Invoice #007612</b><br>
		          	<br>
		          	<b>Order ID:</b> 4F3S8J<br>
		          	<b>Payment Due:</b> 2/22/2014<br>
		          	<b>Account:</b> 968-34567
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		    
		    <!-- Table row -->
		    <div class="row">
		        <div class="col-xs-12 table-responsive">
		        	<table class="table table-striped">
			            <thead>
				            <tr>
				            	<th>Qty</th>
				            	<th>Product</th>
				            	<th>Serial #</th>
				            	<th>Description</th>
				            	<th>Subtotal</th>
				            </tr>
			            </thead>
			            <tbody>
				            <tr>
				              	<td>1</td>
				              	<td>Call of Duty</td>
				              	<td>455-981-221</td>
				              	<td>El snort testosterone trophy driving gloves handsome</td>
				              	<td>$64.50</td>
				            </tr>
				            <tr>
				              	<td>1</td>
				              	<td>Need for Speed IV</td>
				              	<td>247-925-726</td>
				              	<td>Wes Anderson umami biodiesel</td>
				              	<td>$50.00</td>
				            </tr>
				            <tr>
				              	<td>1</td>
				              	<td>Monsters DVD</td>
				              	<td>735-845-642</td>
				              	<td>Terry Richardson helvetica tousled street art master</td>
				              	<td>$10.70</td>
				            </tr>
				            <tr>
				              	<td>1</td>
				              	<td>Grown Ups Blue Ray</td>
				              	<td>422-568-642</td>
				              	<td>Tousled lomo letterpress</td>
				              	<td>$25.99</td>
				            </tr>
			            </tbody>
		        	</table>
		        </div><!-- /.col -->
		    </div><!-- /.row -->
		    
		    <!-- accepted payments column -->
		    <div class="row">
		        <div class="col-xs-6">
		        	<p class="lead">Payment Methods:</p>
		          	<img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/visa.png" alt="Visa">
		          	<img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/mastercard.png" alt="Mastercard">
		          	<img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/american-express.png" alt="American Express">
		          	<img src="https://adminlte.io/themes/AdminLTE/dist/img/credit/paypal2.png" alt="Paypal">
		
		          	<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
		            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
		            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
		          	</p>
		        </div><!-- /.col -->
		        <div class="col-xs-6">
		          	<p class="lead">Amount Due 2/22/2014</p>
		
		          	<div class="table-responsive">
			            <table class="table">
			            	<tr>
			                	<th style="width:50%">Subtotal:</th>
			                	<td>$250.30</td>
			              	</tr>
			              	<tr>
			                	<th>Tax (9.3%)</th>
			                	<td>$10.34</td>
			              	</tr>
			              	<tr>
			                	<th>Shipping:</th>
			                	<td>$5.80</td>
			              	</tr>
			              	<tr>
			                	<th>Total:</th>
			                	<td>$265.24</td>
			              	</tr>
			            </table>
		          	</div>
		        </div><!-- /.col -->
      		</div><!-- /.row -->
      		
      		<!-- this row will not appear when printing -->
	      	<div class="row no-print">
		        <div class="col-xs-12">
		          	<a href="" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
		          	<button type="button" class="btn btn-success pull-right">
		          		<i class="fa fa-credit-card"></i> Submit Payment
		   			</button>
		          	<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
		            	<i class="fa fa-download"></i> Generate PDF
		          	</button>
		        </div>
	      	</div>
		    
	    </section>';
	}
}