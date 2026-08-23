<?php

namespace cinghie\adminlte\tests\unit;

use cinghie\adminlte\tests\TestCase;
use cinghie\adminlte\widgets\ColorPicker;
use cinghie\adminlte\widgets\DatePicker;
use cinghie\adminlte\widgets\DateTimePicker;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\web\View;

class InputWidgetsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplication();
    }

    public function testDateTimePickerDefaultsAndOverrides(): void
    {
        $default = new DateTimePicker(['name' => 'starts_at']);

        $this->assertSame(DateTimePicker::TYPE_COMPONENT_PREPEND, $default->type);
        $this->assertFalse($default->removeButton);
        $this->assertSame('yyyy-mm-dd hh:ii:ss', $default->pluginOptions['format']);
        $this->assertTrue($default->pluginOptions['autoclose']);
        $this->assertTrue($default->pluginOptions['todayHighlight']);

        $custom = new DateTimePicker([
            'name' => 'custom_starts_at',
            'type' => DateTimePicker::TYPE_INPUT,
            'removeButton' => ['icon' => 'custom-remove'],
            'pluginOptions' => [
                'format' => 'dd/mm/yyyy hh:ii',
                'autoclose' => false,
                'todayHighlight' => false,
            ],
        ]);

        $this->assertSame(DateTimePicker::TYPE_INPUT, $custom->type);
        $this->assertIsArray($custom->removeButton);
        $this->assertSame('custom-remove', $custom->removeButton['icon'] ?? null);
        $this->assertSame('dd/mm/yyyy hh:ii', $custom->pluginOptions['format']);
        $this->assertFalse($custom->pluginOptions['autoclose']);
        $this->assertFalse($custom->pluginOptions['todayHighlight']);
    }

    public function testDatePickerKeepsDateOnlyDefaultsAndAllowsOverrides(): void
    {
        $default = new DatePicker(['name' => 'date']);
        $this->assertSame('yyyy-mm-dd', $default->pluginOptions['format']);
        $this->assertSame(2, $default->pluginOptions['minView']);

        $custom = new DatePicker([
            'name' => 'custom_date',
            'pluginOptions' => [
                'format' => 'dd/mm/yyyy',
                'minView' => 3,
            ],
        ]);
        $this->assertSame('dd/mm/yyyy', $custom->pluginOptions['format']);
        $this->assertSame(3, $custom->pluginOptions['minView']);
    }

    public function testColorPickerRendersModelBoundAndStandaloneInputs(): void
    {
        $model = new DynamicModel(['color' => '#3c8dbc']);
        $model->addRule('color', 'string');

        $html = ColorPicker::widget([
            'model' => $model,
            'attribute' => 'color',
            'iconClass' => 'fa fa-paint-brush',
        ]);

        $this->assertStringContainsString('name="DynamicModel[color]"', $html);
        $this->assertStringContainsString('value="#3c8dbc"', $html);
        $this->assertStringContainsString('cinghie-color-popover', $html);
        $this->assertStringContainsString('hidden', $html);
        $this->assertStringContainsString('fa fa-paint-brush', $html);

        $standalone = ColorPicker::widget([
            'name' => 'accent',
            'value' => '#00a65a',
        ]);

        $this->assertStringContainsString('name="accent"', $standalone);
        $this->assertStringContainsString('value="#00a65a"', $standalone);
    }

    public function testColorPickerPreservesCallerInputOptionsAndEncodesLabel(): void
    {
        $html = ColorPicker::widget([
            'name' => 'accent',
            'value' => '#abc',
            'label' => '<script>alert(1)</script>',
            'options' => [
                'id' => 'custom-accent',
                'maxlength' => 12,
                'placeholder' => 'Custom HEX',
            ],
        ]);

        $this->assertStringContainsString('id="custom-accent"', $html);
        $this->assertStringContainsString('maxlength="12"', $html);
        $this->assertStringContainsString('placeholder="Custom HEX"', $html);
        $this->assertStringContainsString('background-color:#aabbcc;', $html);
        $this->assertStringNotContainsString('<script>alert(1)</script>', $html);
        $this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;', $html);
    }

    public function testColorPickerRejectsInvalidPaletteConfiguration(): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('ColorPicker::palette');

        ColorPicker::widget([
            'name' => 'accent',
            'palette' => 'not-an-array',
        ]);
    }

    public function testColorPickerSkipsUnsafePaletteValues(): void
    {
        $html = ColorPicker::widget([
            'name' => 'accent',
            'palette' => [
                '#00a65a',
                '#abc',
                'red; background-image:url(javascript:alert(1))',
                ['not-a-color'],
            ],
        ]);

        $this->assertStringContainsString('data-color="#00a65a"', $html);
        $this->assertStringContainsString('data-color="#aabbcc"', $html);
        $this->assertStringNotContainsString('background-image', $html);
        $this->assertStringNotContainsString('javascript:', $html);
        $this->assertStringNotContainsString('Array', $html);
    }

    public function testMultipleColorPickersShareOneClientAssetRegistration(): void
    {
        $first = ColorPicker::widget([
            'name' => 'accent_a',
            'options' => ['id' => 'accent-a'],
        ]);
        $second = ColorPicker::widget([
            'name' => 'accent_b',
            'options' => ['id' => 'accent-b'],
        ]);

        $this->assertStringContainsString('id="accent-a"', $first);
        $this->assertStringContainsString('id="accent-b"', $second);
        $this->assertArrayHasKey('cinghie-adminlte-color-picker', \Yii::$app->view->css);
        $this->assertArrayHasKey(
            'cinghie-adminlte-color-picker',
            \Yii::$app->view->js[View::POS_READY] ?? []
        );
    }

    public function testDateTimePickerAndDatePickerRenderRealBootstrap3Markup(): void
    {
        $model = new DynamicModel([
            'starts_at' => '2026-08-23 20:30:00',
            'date' => '2026-08-23',
        ]);

        $dateTime = DateTimePicker::widget([
            'model' => $model,
            'attribute' => 'starts_at',
        ]);
        $date = DatePicker::widget([
            'model' => $model,
            'attribute' => 'date',
        ]);

        $this->assertStringContainsString('name="DynamicModel[starts_at]"', $dateTime);
        $this->assertStringContainsString('input-group', $dateTime);
        $this->assertStringContainsString('name="DynamicModel[date]"', $date);
        $this->assertStringContainsString('2026-08-23', $date);
    }

    public function testComposerDeclaresKartikWidgetsForPublicDateWidgets(): void
    {
        $composer = json_decode(file_get_contents(dirname(__DIR__, 2) . '/composer.json'), true);
        $this->assertSame('^3.4.1', $composer['require']['kartik-v/yii2-widgets'] ?? null);
        $this->assertArrayNotHasKey('kartik-v/yii2-widgets', $composer['suggest'] ?? []);
    }
}
