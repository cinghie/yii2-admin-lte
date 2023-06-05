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
use cinghie\crm\models\Accounts;
use cinghie\crm\models\Contacts;
use cinghie\commerce\models\Manufacturer;
use cinghie\commerce\models\Shops;
use cinghie\userextended\models\User;
use yii\bootstrap\Widget;
use yii\helpers\Url;

/**
 * Timeline
 */
class Timeline extends Widget
{
    /**
     * @var array
     */
    public $days;
    /**
     * @var array
     */
    public $items;

    /**
     * @inheritdoc
     */
    public function init()
    {

    }

    /**
     * @param $day
     * @return string
     */
    public function timelineItem($day)
    {
        $html = '';

        foreach ($this->items as $item)
        {
            if(isset($item) && $item->created_date === $day)
            {
                $username = User::find()->where(['id'=> $item->created_by])->one()->username;
                $userurl = Url::toRoute(['/logger/loggers/timeline', 'user_id' => $item->created_by]);

                switch ($item->action)
                {
                    case 'create':
                        $bgColor = ' color-create';
                        break;
                    case 'update':
                        $bgColor = ' color-update';
                        break;
                    case 'delete':
                        $bgColor = ' color-delete';
                        break;
                    default:
                        $bgColor = '';
                }

                $html .= '<div class=""><i class="'.$item->icon.$bgColor.'"></i>';
                $html .= '<div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> '.substr($item->created_time, 0, 5).'</span>';
                $html .= '<h3 class="timeline-header"><a href="'.$userurl.'">'.$username.'</a> ';
                $html .= Yii::t('traits', $item->action).' <strong>'.$item->entity_name.'</strong></h3>';

                $html .= '<div class="timeline-body">';

                switch ($item->entity_model)
                {
                    case 'Accounts':

                        $elementModel = new Accounts();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->name.'">'.$element->name.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

                    case 'Contacts':

                        $elementModel = new Contacts();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->getFullName().'">'.$element->getFullName().'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

                    case 'Manufacturer':

                        $elementModel = new Manufacturer();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->name.'">'.$element->name.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

                    case 'Shops':

                        $elementModel = new Shops();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->name.'">'.$element->name.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;
                }

                $html .= '</div>';

                $html .= '</div>';
                $html .= '</div>';
            }
        }

        return $html;
    }

    /**
     * @param $day
     * @return string
     */
    public function timelineDay($day)
    {
        $html = '<div class="timeline"><div class="time-label"><span class="bg-red">'.$day.'</span></div>';
        $html .= $this->timelineItem($day);
        $html .= '</div>';

        return $html;
    }

    /**
     * @return string
     */
    public function run()
    {
        $html = '<section class="timeline">';
        $html .= '<div class="row"><div class="col-md-12">';

        foreach ($this->days as $day) {
            $html .= $this->timelineDay($day['created_date']);
        }

        $html .= '</div></div>';
        $html .= '</section">';

        return $html;
    }
}
