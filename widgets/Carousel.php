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

        parent::init();
        Html::addCssClass($this->options, 'cinghie-adminlte-carousel');
    }

    /**
     * {@inheritdoc}
     */
    public function renderItem($item, $index)
    {
        if (is_string($item) || is_numeric($item)) {
            $item = $this->encodeContent ? Html::encode((string) $item) : (string) $item;

            return parent::renderItem($item, $index);
        }

        if (!is_array($item) || !array_key_exists('content', $item)) {
            throw new InvalidConfigException('Each Carousel item must be a string or contain a "content" option.');
        }

        $encodeContent = ArrayHelper::getValue($item, 'encodeContent', $this->encodeContent);
        $encodeCaption = ArrayHelper::getValue($item, 'encodeCaption', $this->encodeCaptions);

        if ($encodeContent) {
            $item['content'] = Html::encode((string) $item['content']);
        }
        if (array_key_exists('caption', $item) && $item['caption'] !== null && $encodeCaption) {
            $item['caption'] = Html::encode((string) $item['caption']);
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
                Html::encode((string) $controls[0]),
                Html::encode((string) $controls[1]),
            ];
            try {
                return parent::renderControls();
            } finally {
                $this->controls = $controls;
            }
        }

        return parent::renderControls();
    }
}
