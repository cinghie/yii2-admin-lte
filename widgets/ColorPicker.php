<?php

namespace cinghie\adminlte\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\InputWidget;

/**
 * Bootstrap 3/AdminLTE 2 color input with HEX text, preview and deferred palette.
 */
class ColorPicker extends InputWidget
{
    public const DEFAULT_PALETTE = [
        '#3c8dbc', '#00c0ef', '#00a65a', '#f39c12', '#f56954', '#d81b60', '#605ca8', '#001f3f',
        '#39cccc', '#01ff70', '#ffdc00', '#ff851b', '#dd4b39', '#b10dc9', '#111111', '#7f8c8d',
    ];

    public $palette = self::DEFAULT_PALETTE;
    public $iconClass = 'fa fa-paint-brush';
    public $label = 'Color';

    public function init()
    {
        parent::init();

        if (!is_array($this->palette)) {
            throw new InvalidConfigException('ColorPicker::palette must be an array.');
        }
        if ($this->iconClass !== null && !is_string($this->iconClass)) {
            throw new InvalidConfigException('ColorPicker::iconClass must be a string or null.');
        }

        $this->label = $this->stringify($this->label, 'ColorPicker::label');
    }

    public function run()
    {
        $id = $this->options['id'] ?? ($this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId());
        $textOptions = $this->options;
        $textOptions['id'] = $id;
        $textOptions['maxlength'] = $textOptions['maxlength'] ?? 32;
        $textOptions['placeholder'] = $textOptions['placeholder'] ?? '#3c8dbc';
        Html::addCssClass($textOptions, 'form-control cinghie-color-value');

        $value = (string) ($this->hasModel() ? Html::getAttributeValue($this->model, $this->attribute) : $this->value);
        $nativeValue = $this->normalizeHexColor($value) ?? '#3c8dbc';
        $pickerId = $id . '-native';
        $toggleId = $id . '-toggle';
        $paletteId = $id . '-palette';

        $swatches = '';
        foreach ($this->palette as $color) {
            $normalized = $this->normalizeHexColor($color);
            if ($normalized === null) {
                continue;
            }

            $selected = $normalized === $nativeValue;
            $swatches .= Html::button('', [
                'type' => 'button',
                'class' => 'cinghie-color-swatch' . ($selected ? ' is-selected' : ''),
                'title' => $normalized,
                'aria-label' => $normalized,
                'aria-pressed' => $selected ? 'true' : 'false',
                'data-color' => $normalized,
                'style' => 'background-color:' . $normalized . ';',
            ]);
        }

        $html = Html::beginTag('div', ['class' => 'cinghie-color-picker', 'data-color-picker' => $id]);
        $html .= Html::beginTag('div', ['class' => 'cinghie-color-row']);
        if (is_string($this->iconClass) && trim($this->iconClass) !== '') {
            $html .= Html::tag(
                'span',
                Html::tag('i', '', ['class' => trim($this->iconClass)]),
                ['class' => 'cinghie-color-addon', 'aria-hidden' => 'true']
            );
        }
        $html .= $this->hasModel()
            ? Html::activeTextInput($this->model, $this->attribute, $textOptions)
            : Html::textInput($this->name, $this->value, $textOptions);
        $html .= Html::button(
            Html::tag('span', '', [
                'class' => 'cinghie-color-preview',
                'style' => 'background-color:' . $nativeValue . ';',
                'aria-hidden' => 'true',
            ]) . Html::tag('span', '▾', ['class' => 'cinghie-color-chevron', 'aria-hidden' => 'true']),
            [
                'id' => $toggleId,
                'type' => 'button',
                'class' => 'btn btn-default cinghie-color-toggle',
                'title' => $this->label,
                'aria-label' => $this->label,
                'aria-haspopup' => 'true',
                'aria-expanded' => 'false',
                'aria-controls' => $paletteId,
            ]
        );
        $html .= Html::endTag('div');
        $html .= Html::beginTag('div', ['id' => $paletteId, 'class' => 'cinghie-color-popover', 'hidden' => true]);
        $html .= Html::tag('div', Html::encode($this->label), ['class' => 'cinghie-color-popover-title']);
        $html .= Html::tag('div', $swatches, ['class' => 'cinghie-color-palette']);
        $html .= Html::beginTag('label', ['class' => 'cinghie-color-custom']);
        $html .= Html::tag('span', Html::encode($this->label));
        $html .= Html::input('color', null, $nativeValue, [
            'id' => $pickerId,
            'class' => 'cinghie-color-native',
            'aria-label' => $this->label,
        ]);
        $html .= Html::endTag('label') . Html::endTag('div') . Html::endTag('div');

        $this->registerClientAssets();

        return $html;
    }

    protected function registerClientAssets()
    {
        $this->getView()->registerCss(<<<CSS
.cinghie-color-picker{position:relative;display:block;width:100%;min-width:0}.cinghie-color-row{display:flex;align-items:stretch;width:100%;min-width:0}.cinghie-color-addon{display:flex;align-items:center;justify-content:center;flex:0 0 46px;width:46px;padding:6px 12px;color:#555;background:#eee;border:1px solid #ccc;border-right:0;border-radius:4px 0 0 4px}.cinghie-color-row .cinghie-color-value{flex:1 1 auto;width:1%;min-width:0;border-radius:0}.cinghie-color-row .cinghie-color-value:first-child{border-top-left-radius:4px;border-bottom-left-radius:4px}.cinghie-color-toggle{display:flex;align-items:center;justify-content:center;gap:6px;flex:0 0 58px;width:58px;min-width:58px;padding:4px 7px;border-top-left-radius:0;border-bottom-left-radius:0}.cinghie-color-preview{display:block;width:24px;height:20px;border:1px solid rgba(0,0,0,.2);border-radius:3px}.cinghie-color-chevron{font-size:11px;line-height:1;color:#777}.cinghie-color-popover{position:absolute;right:0;z-index:1060;width:236px;max-width:calc(100vw - 24px);margin-top:6px;padding:10px;background:#fff;border:1px solid #d2d6de;border-radius:4px;box-shadow:0 6px 18px rgba(0,0,0,.16)}.cinghie-color-popover[hidden]{display:none!important}.cinghie-color-popover-title{margin:0 0 8px;font-size:12px;font-weight:600;color:#555}.cinghie-color-palette{display:grid;grid-template-columns:repeat(4,1fr);gap:7px}.cinghie-color-swatch{width:100%;height:34px;padding:0;border:2px solid transparent;border-radius:4px;cursor:pointer;box-shadow:inset 0 0 0 1px rgba(0,0,0,.16)}.cinghie-color-swatch:hover,.cinghie-color-swatch:focus{outline:0;border-color:#8aa4b8}.cinghie-color-swatch.is-selected{border-color:#3c8dbc;box-shadow:0 0 0 1px #fff,0 0 0 3px #3c8dbc}.cinghie-color-custom{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:10px 0 0;padding-top:9px;border-top:1px solid #eee;font-size:12px;font-weight:400;color:#666;cursor:pointer}.cinghie-color-native{display:block;width:44px;height:30px;padding:1px;border:1px solid #ccc;border-radius:4px;background:#fff;cursor:pointer}@media(max-width:991px){.cinghie-color-popover{left:0;right:auto;width:min(260px,calc(100vw - 32px));max-width:calc(100vw - 32px)}}
CSS
        , [], 'cinghie-adminlte-color-picker');

        $this->getView()->registerJs(<<<JS
(function(){
function rootOf(el){return el&&el.closest?el.closest('[data-color-picker]'):null}
function parts(root){return{input:root.querySelector('.cinghie-color-value'),nativePicker:root.querySelector('.cinghie-color-native'),toggle:root.querySelector('.cinghie-color-toggle'),palette:root.querySelector('.cinghie-color-popover'),preview:root.querySelector('.cinghie-color-preview')}}
function normalize(v){v=String(v||'').trim();if(/^#[0-9a-f]{6}$/i.test(v))return v.toLowerCase();if(/^#[0-9a-f]{3}$/i.test(v))return('#'+v.slice(1).split('').map(function(c){return c+c}).join('')).toLowerCase();return null}
function open(root,value){var p=parts(root);if(!p.palette||!p.toggle)return;p.palette.hidden=!value;p.toggle.setAttribute('aria-expanded',value?'true':'false')}
function sync(root,value,change){var p=parts(root),n=normalize(value);if(!n||!p.input||!p.nativePicker)return;p.input.value=n;p.nativePicker.value=n;if(p.preview)p.preview.style.backgroundColor=n;p.palette.querySelectorAll('.cinghie-color-swatch').forEach(function(s){var selected=s.getAttribute('data-color')===n;s.classList.toggle('is-selected',selected);s.setAttribute('aria-pressed',selected?'true':'false')});if(change)p.input.dispatchEvent(new Event('change',{bubbles:true}))}
function closeOthers(except){document.querySelectorAll('[data-color-picker]').forEach(function(root){if(root!==except)open(root,false)})}
document.addEventListener('click',function(e){var toggle=e.target.closest('.cinghie-color-toggle'),swatch=e.target.closest('[data-color]'),root=rootOf(toggle||swatch);if(toggle&&root){var p=parts(root);closeOthers(root);open(root,p.palette.hidden);return}if(swatch&&root){sync(root,swatch.getAttribute('data-color'),true);open(root,false);var t=parts(root).toggle;if(t)t.focus();return}document.querySelectorAll('[data-color-picker]').forEach(function(r){if(!r.contains(e.target))open(r,false)})});
document.addEventListener('input',function(e){if(!e.target.classList.contains('cinghie-color-native'))return;var root=rootOf(e.target);if(root)sync(root,e.target.value,true)});
document.addEventListener('change',function(e){var root=rootOf(e.target);if(!root)return;if(e.target.classList.contains('cinghie-color-native')){open(root,false);var t=parts(root).toggle;if(t)t.focus();return}if(e.target.classList.contains('cinghie-color-value')){var n=normalize(e.target.value);if(n)sync(root,n,false)}});
document.addEventListener('keydown',function(e){if(e.key!=='Escape')return;document.querySelectorAll('[data-color-picker]').forEach(function(root){var p=parts(root);if(p.palette&&!p.palette.hidden){open(root,false);if(p.toggle)p.toggle.focus()}})});
})();
JS
        , View::POS_READY, 'cinghie-adminlte-color-picker');
    }

    protected function normalizeHexColor($value)
    {
        if (is_object($value) && method_exists($value, '__toString')) {
            $value = (string) $value;
        }
        if (!is_string($value) && !is_numeric($value)) {
            return null;
        }

        $value = strtolower(trim((string) $value));
        if (preg_match('/^#[0-9a-f]{6}$/', $value)) {
            return $value;
        }
        if (preg_match('/^#[0-9a-f]{3}$/', $value)) {
            return '#' . $value[1] . $value[1] . $value[2] . $value[2] . $value[3] . $value[3];
        }

        return null;
    }

    protected function stringify($value, $name)
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
