<?php

namespace cinghie\adminlte\tests\unit;

use cinghie\adminlte\tests\TestCase;
use cinghie\adminlte\widgets\ColorPicker;
use cinghie\adminlte\widgets\DatePicker;
use cinghie\adminlte\widgets\DateTimePicker;
use yii\base\DynamicModel;

class InputWidgetsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplication();
    }

    public function testDateWidgetsExposeBootstrap3Defaults(): void
    {
        $dateTime = file_get_contents(dirname(__DIR__, 2) . '/widgets/DateTimePicker.php');
        $date = file_get_contents(dirname(__DIR__, 2) . '/widgets/DatePicker.php');

        $this->assertStringContainsString('extends KartikDateTimePicker', $dateTime);
        $this->assertStringContainsString('TYPE_COMPONENT_PREPEND', $dateTime);
        $this->assertStringContainsString("'format' => 'yyyy-mm-dd hh:ii:ss'", $dateTime);
        $this->assertStringContainsString("'todayHighlight' => true", $dateTime);
        $this->assertStringContainsString('extends DateTimePicker', $date);
        $this->assertStringContainsString("'format' => 'yyyy-mm-dd'", $date);
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

    public function testColorPickerIsDeferredResponsiveAndGeneric(): void
    {
        $src = file_get_contents(dirname(__DIR__, 2) . '/widgets/ColorPicker.php');

        $this->assertStringContainsString("'hidden' => true", $src);
        $this->assertStringContainsString('cinghie-color-popover', $src);
        $this->assertStringContainsString('cinghie-color-toggle', $src);
        $this->assertStringContainsString('DEFAULT_PALETTE', $src);
        $this->assertStringContainsString('@media(max-width:991px)', $src);
        $this->assertStringContainsString("public \$iconClass = 'fa fa-paint-brush'", $src);
        $this->assertStringContainsString('$this->hasModel()', $src);
        $this->assertStringContainsString('Html::textInput($this->name, $this->value', $src);
        $this->assertStringNotContainsString("Yii::t('events'", $src);
    }

    public function testComposerDeclaresKartikWidgetsForPublicDateWidgets(): void
    {
        $composer = json_decode(file_get_contents(dirname(__DIR__, 2) . '/composer.json'), true);
        $this->assertSame('^3.4.1', $composer['require']['kartik-v/yii2-widgets'] ?? null);
        $this->assertArrayNotHasKey('kartik-v/yii2-widgets', $composer['suggest'] ?? []);
    }
}
