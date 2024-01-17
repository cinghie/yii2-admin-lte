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
use cinghie\commerce\models\Accounts;
use cinghie\commerce\models\Carrier;
use cinghie\commerce\models\Category as ProductCategory;
use cinghie\commerce\models\Contacts;
use cinghie\commerce\models\Currency;
use cinghie\commerce\models\Entry;
use cinghie\commerce\models\Expense;
use cinghie\commerce\models\Manufacturer;
use cinghie\commerce\models\Order;
use cinghie\commerce\models\Payment;
use cinghie\commerce\models\PaymentMethod;
use cinghie\commerce\models\Product;
use cinghie\commerce\models\ProductAttribute;
use cinghie\commerce\models\Quote;
use cinghie\commerce\models\Shop;
use cinghie\commerce\models\Tax;
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
    public array $days;

    /**
     * @var array
     */
    public array $items;

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
                    case 'Attribute':

                        $elementModel = new ProductAttribute();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->getCombinationName().'">'.$element->getCombinationName().'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

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

                    case 'Carrier':

                        $elementModel = new Carrier();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->name.'">'.$element->name.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

                    case 'Category':

                        $elementModel = new ProductCategory();
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

                    case 'Currency':

                        $elementModel = new Currency();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->name.'">'.$element->name.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

                    case 'Entry':

                        $elementModel = new Entry();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->name.'">'.$element->name.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

                    case 'Expense':

                        $elementModel = new Expense();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->name.'">'.$element->name.'</a>';
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

                    case 'Order':

                        $elementModel = new Order();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->reference.'">'.$element->reference.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

                    case 'Payment':

                        $elementModel = new Payment();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->reference.'">'.$element->reference.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

                    case 'PaymentMethod':

                        $elementModel = new PaymentMethod();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->name.'">'.$element->name.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

                    case 'Product':

                        $elementModel = new Product();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->name.'">'.$element->name.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

	                case 'Quote':

		                $elementModel = new Quote();
		                $element = $elementModel::findOne($item->entity_id);
		                $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

		                if($element) {
			                $html .= '<a href="'.$url.'" title="'.$element->reference.'">'.$element->reference.'</a>';
		                } else {
			                $html .= $item->data ?? '';
		                }

		                break;

                    case 'Shop':

                        $elementModel = new Shop();
                        $element = $elementModel::findOne($item->entity_id);
                        $url = Url::toRoute([$item->entity_url, 'id' => $item->entity_id]);

                        if($element) {
                            $html .= '<a href="'.$url.'" title="'.$element->name.'">'.$element->name.'</a>';
                        } else {
                            $html .= $item->data ?? '';
                        }

                        break;

                    case 'Tax':

                        $elementModel = new Tax();
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
