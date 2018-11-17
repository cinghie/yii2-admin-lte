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
use yii\helpers\Html;

class MailboxRead extends Widget
{
	public $mailAttachments;
	public $mailBody;
	public $mailSender;
	public $mailSubject;
	public $userName;
	public $userImage;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		if($this->mailAttachments === null) {
			$this->mailAttachments = [];
		}

		if($this->mailBody === null) {
			$this->mailBody = 'Set param mailBody';
		}

		if($this->mailSender === null) {
			$this->mailSender = 'Set param mailSender';
		}

		if($this->mailSubject === null) {
			$this->mailSubject = 'Set param mailSubject';
		}

		if($this->userName === null) {
			$this->userName = 'Set param userName';
		}

		if($this->userImage === null) {
			$this->userImage = '';
		}
	}

	/**
	 * @return string
	 */
	public function run()
	{
		$html  = '<div class="box box-widget">';

		$html .= '<div class="box-header with-border">';

		$html .= '<div class="mailbox-read-info">';
		$html .= '<div class="user-block">';
		if($this->userImage) {
			$html .= '<img class="img-circle" src="'.$this->userImage.'" alt="'.$this->userName.'" title="'.$this->userName.'">';
		}
		$html .= '<span class="username">'.$this->mailSubject.'</span>';
		$html .= '<span class="description">'.$this->mailSender.'</span>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="mailbox-read-message">'.$this->mailBody.'</div>';
		
		$html .= '</div>';

		$html .= '<div class="box-footer">'.$this->printAttachments().'</div>';

		$html .= '</div>';

		return $html;
	}

	/**
	 * @return string
	 */
	public function demo()
	{
		$html  = '<div class="box box-widget">';

		$html .= '<div class="box-header with-border">';

		$html .= '<div class="mailbox-read-info">';

		$html .= '<div class="user-block">';
		$html .= '<img class="img-circle" src="https://adminlte.io/themes/AdminLTE/dist/img/user2-160x160.jpg" alt="John Doe" title="John Doe">';
		$html .= '<span class="username">Message Subject Is Placed Here</span>';
		$html .= '<span class="description">John Doe < example@example.com ></span>';
		$html .= '</div>';

		$html .= '</div>';

		$html .= '<div class="mailbox-controls with-border text-center">';
		$html .= '<div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Delete">
                    <i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Reply">
                    <i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Forward">
                    <i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="" data-original-title="Print">';
		$html .= '</div>';

		$html .= '<div class="mailbox-read-message">
                <p>Hello John,</p>

                <p>Keffiyeh blog actually fashion axe vegan, irony biodiesel. Cold-pressed hoodie chillwave put a bird
                  on it aesthetic, bitters brunch meggings vegan iPhone. Dreamcatcher vegan scenester mlkshk. Ethical
                  master cleanse Bushwick, occupy Thundercats banjo cliche ennui farm-to-table mlkshk fanny pack
                  gluten-free. Marfa butcher vegan quinoa, bicycle rights disrupt tofu scenester chillwave 3 wolf moon
                  asymmetrical taxidermy pour-over. Quinoa tote bag fashion axe, Godard disrupt migas church-key tofu
                  blog locavore. Thundercats cronut polaroid Neutra tousled, meh food truck selfies narwhal American
                  Apparel.</p>

                <p>Thanks,<br>Jane</p>
              </div>';

		$html .= '</div>';

		$html .= '<div class="box-footer">';
		$html .= '<ul class="mailbox-attachments clearfix">
                <li>
                  <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Sep2014-report.pdf</a>
                        <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li>
                <li>
                  <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
                        <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li>
                <li>
                  <span class="mailbox-attachment-icon has-img"><img src="https://adminlte.io/themes/AdminLTE/dist/img/photo1.png" alt="Attachment"></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                        <span class="mailbox-attachment-size">
                          2.67 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li>
                <li>
                  <span class="mailbox-attachment-icon has-img"><img src="https://adminlte.io/themes/AdminLTE/dist/img/photo2.png" alt="Attachment"></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                        <span class="mailbox-attachment-size">
                          1.9 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li>
              </ul>';
		$html .= '</div>';

		$html .= '<div class="box-footer">';
		$html .= '<div class="pull-right">
                <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
              </div>
              <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button>
              <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>';
		$html .= '</div>';

		$html .= '</div>';

		return $html;
	}

	/**
	 * @return string
	 */
	private function printAttachments()
	{
		$html = '';

		if(!empty($this->mailAttachments))
		{
			$html .= '<ul class="mailbox-attachments clearfix">';

			foreach ($this->mailAttachments as $attachment)
			{
				if(!empty($attachment))
				{
					$html .= '<li>
				    	<span class="mailbox-attachment-icon">
				    		'.$attachment->getAttachmentPreview('img-responsive','display: block; height: 92px; margin: 0 auto; max-width: 100%;').'
				    	</span>
						<div class="mailbox-attachment-info">
				        	<a href="'.$attachment->fileUrl.'" class="mailbox-attachment-name" style="display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
				            	<i class="fa fa-paperclip"></i> '.Html::encode($attachment->filename).'
				            </a>
				            <span class="mailbox-attachment-size">'.$attachment->formatSize().'</span>
				        </div>
				        </li>';
				}
			}

			$html .= '</ul>';
		}

		return $html;
	}
}
