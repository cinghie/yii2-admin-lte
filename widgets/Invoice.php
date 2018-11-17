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

use yii\bootstrap\Widget;

class Invoice extends Widget
{
	public $companyName;
	public $invoiceDate;
	public $invoiceFromName;
	public $invoiceFromAddress;
	public $invoiceFromAddressInfo;
	public $invoiceFromPhone;
	public $invoiceFromEmail;
	public $invoiceToName;
	public $invoiceToAddress;
	public $invoiceToAddressInfo;
	public $invoiceToPhone;
	public $invoiceToEmail;
	public $invoiceNumber;
	public $invoiceOrderID;
	public $invoicePaymentDue;
	public $invoiceAccount;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		if ($this->companyName === null) {
			$this->companyName = 'AdminLTE, Inc.';
		}

		if ($this->invoiceDate === null) {
			$this->invoiceDate = '2/10/2014';
		}
	}

	/**
	 * @return string
	 */
	public function run()
	{
		return '<section class="invoice">

	      	<!-- title row -->
	      	<div class="row">
		        <div class="col-xs-12">
			    	<h2 class="page-header">
			        	<i class="fa fa-globe"></i> '.$this->companyName.'
			            <small class="pull-right">'.\Yii::t('traits', 'Date').': '.$this->invoiceDate.'</small>
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