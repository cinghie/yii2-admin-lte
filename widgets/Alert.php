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

use Exception;
use Yii;
use yii\bootstrap\Alert as BootstrapAlert;
use yii\bootstrap\Widget;

/**
 * Class Alert
 */
class Alert extends Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the array:
     *       - class of alert type (i.e. danger, success, info, warning)
     *       - icon for alert AdminLTE
     */
    public $alertTypes = [
        'error' => [
            'class' => 'alert-danger',
            'icon' => '<i class="icon fas fa-ban"></i>',
        ],
        'danger' => [
            'class' => 'alert-danger',
            'icon' => '<i class="icon fas fa-ban"></i>',
        ],
        'success' => [
            'class' => 'alert-success',
            'icon' => '<i class="icon fas fa-check"></i>',
        ],
        'info' => [
            'class' => 'alert-info',
            'icon' => '<i class="icon fas fa-info"></i>',
        ],
        'warning' => [
            'class' => 'alert-warning',
            'icon' => '<i class="icon fas fa-exclamation-triangle"></i>',
        ],
    ];

    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    /**
     * @var boolean whether to removed flash messages during AJAX requests
     */
    public $isAjaxRemoveFlash = true;

    /**
     * Initializes the widget.
     * This method will register the bootstrap asset bundle. If you override this method,
     * make sure you call the parent implementation first.
     *
     * @throws Exception
     */
    public function init()
    {
        parent::init();

        $session = Yii::$app->getSession();
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $data)
        {
            if (isset($this->alertTypes[$type]))
            {
                $data = (array) $data;

                foreach ($data as $message)
                {

                    $this->options['class'] = $this->alertTypes[$type]['class'] . $appendCss;
                    $this->options['id'] = $this->getId() . '-' . $type;

                    echo BootstrapAlert::widget([
                        'body' => $this->alertTypes[$type]['icon'] . $message,
                        'closeButton' => $this->closeButton,
                        'options' => $this->options,
                    ]);
                }

                if ($this->isAjaxRemoveFlash && !Yii::$app->request->isAjax) {
                    $session->removeFlash($type);
                }
            }
        }
    }
}
