<?php

namespace cinghie\adminlte\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap\Carousel as BootstrapCarousel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * AdminLTE 2 / Bootstrap 3 carousel with safe output defaults.
 *
 * Each item may be a string or an array containing `content`, optional `caption`,
 * `options`, and per-item `encodeContent` / `encodeCaption` flags.
 */
class Carousel extends BootstrapCarousel
{
    /** @var bool whether slide content is HTML-encoded by default */
    public $encodeContent = true;

    /** @var bool whether captions are HTML-encoded by default */
    public $encodeCaptions = true;

    /** @var bool whether custom previous/next labels are HTML-encoded */
    public $encodeControls = true;

    /** @var array|false */
    public $controls = ['‹', '›'];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!is_array($this->items)) {
            throw new InvalidConfigException('Carousel "items" must be an array.');
        }
        if ($this->controls !== false && (!is_array($this->controls) || count($this->controls) !== 2)) {
            throw new InvalidConfigException('Carousel "controls" must be false or an array of two elements.');
        }

        if ($this->controls !== false) {
            $this->stringify($this->controls[0], 'Carousel control');
            $this->stringify($this->controls[1], 'Carousel control');
        }

        parent::init();
        Html::addCssClass($this->options, 'cinghie-adminlte-carousel');
    }

    /**
     * {@inheritdoc}
     */
    public function renderItem($item, $index)
    {
        if (!is_array($item)) {
            $content = $this->stringify($item, 'Carousel item');
            $content = $this->encodeContent ? Html::encode($content) : $content;

            return parent::renderItem($content, $index);
        }

        if (!array_key_exists('content', $item)) {
            throw new InvalidConfigException('Each Carousel item must contain a "content" option.');
        }

        $encodeContent = ArrayHelper::getValue($item, 'encodeContent', $this->encodeContent);
        $encodeCaption = ArrayHelper::getValue($item, 'encodeCaption', $this->encodeCaptions);
        $content = $this->stringify($item['content'], 'Carousel item content');
        $item['content'] = $encodeContent ? Html::encode($content) : $content;

        if (array_key_exists('caption', $item) && $item['caption'] !== null) {
            $caption = $this->stringify($item['caption'], 'Carousel item caption');
            $item['caption'] = $encodeCaption ? Html::encode($caption) : $caption;
        }

        unset($item['encodeContent'], $item['encodeCaption']);

        return parent::renderItem($item, $index);
    }

    /**
     * {@inheritdoc}
     */
    public function renderControls()
    {
        if ($this->controls !== false && $this->encodeControls) {
            $controls = $this->controls;
            $this->controls = [
                Html::encode($this->stringify($controls[0], 'Carousel control')),
                Html::encode($this->stringify($controls[1], 'Carousel control')),
            ];
            try {
                return parent::renderControls();
            } finally {
                $this->controls = $controls;
            }
        }

        return parent::renderControls();
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
