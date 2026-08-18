<?php

namespace cinghie\adminlte\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap\Collapse;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * AdminLTE 2 / Bootstrap 3 accordion with safe output defaults.
 *
 * Supports the standard yii\bootstrap\Collapse item format plus a `type`
 * option (`default|primary|success|info|warning|danger`) and per-item
 * `encodeContent` / `encodeFooter` flags.
 */
class Accordion extends Collapse
{
    /** @var string[] */
    private static $panelTypes = ['default', 'primary', 'success', 'info', 'warning', 'danger'];

    /** @var bool whether scalar content and list entries are encoded by default */
    public $encodeContent = true;

    /** @var bool whether item footers are encoded by default */
    public $encodeFooters = true;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!is_array($this->items)) {
            throw new InvalidConfigException('Accordion "items" must be an array.');
        }

        parent::init();
        Html::addCssClass($this->options, 'cinghie-adminlte-accordion');
    }

    /**
     * {@inheritdoc}
     */
    public function renderItems()
    {
        $items = [];
        $index = 0;

        foreach ($this->items as $key => $item) {
            if (!is_array($item)) {
                $item = ['content' => $item];
            }

            if (!array_key_exists('label', $item)) {
                if (is_int($key)) {
                    throw new InvalidConfigException('The "label" option is required.');
                }
                $item['label'] = $key;
            }
            if (!array_key_exists('content', $item)) {
                throw new InvalidConfigException('The "content" option is required.');
            }

            $item['label'] = $this->stringify($item['label'], 'Accordion label');
            $type = ArrayHelper::getValue($item, 'type', 'default');
            if (!is_string($type) || !in_array($type, self::$panelTypes, true)) {
                throw new InvalidConfigException('Invalid Accordion panel type.');
            }

            $item = $this->normalizeItemContent($item);
            $header = $item['label'];
            $options = ArrayHelper::getValue($item, 'options', []);
            if (!is_array($options)) {
                throw new InvalidConfigException('Accordion item "options" must be an array.');
            }
            Html::addCssClass($options, ['panel', 'panel-' . $type]);
            unset($item['type'], $item['encodeContent'], $item['encodeFooter']);

            $items[] = Html::tag('div', $this->renderItem($header, $item, ++$index), $options);
        }

        return implode("\n", $items);
    }

    /**
     * @param array $item
     * @return array
     */
    private function normalizeItemContent(array $item)
    {
        $encodeContent = ArrayHelper::getValue($item, 'encodeContent', $this->encodeContent);
        $encodeFooter = ArrayHelper::getValue($item, 'encodeFooter', $this->encodeFooters);

        if (is_array($item['content'])) {
            foreach ($item['content'] as $key => $value) {
                $value = $this->stringify($value, 'Accordion list item');
                $item['content'][$key] = $encodeContent ? Html::encode($value) : $value;
            }
        } else {
            $content = $this->stringify($item['content'], 'Accordion content');
            $item['content'] = $encodeContent ? Html::encode($content) : $content;
        }

        if (isset($item['footer'])) {
            $footer = $this->stringify($item['footer'], 'Accordion footer');
            $item['footer'] = $encodeFooter ? Html::encode($footer) : $footer;
        }

        return $item;
    }

    /**
     * @param mixed $value
     * @param string $name
     * @return string
     * @throws InvalidConfigException
     */
    private function stringify($value, $name)
    {
        if (is_string($value) || is_numeric($value)) {
            return (string) $value;
        }
        if (is_object($value) && method_exists($value, '__toString')) {
            return (string) $value;
        }

        throw new InvalidConfigException($name . ' must be a string, number, or stringable object.');
    }
}
