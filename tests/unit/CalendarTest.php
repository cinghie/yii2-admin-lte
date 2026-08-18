<?php

namespace cinghie\adminlte\tests\unit;

use cinghie\adminlte\CalendarAsset;
use cinghie\adminlte\CalendarPrintAsset;
use cinghie\adminlte\tests\TestCase;
use cinghie\adminlte\widgets\Calendar;
use yii\base\InvalidConfigException;

class CalendarTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplication();
    }

    public function testRendersCalendarAndRegistersDedicatedAssets(): void
    {
        $html = Calendar::widget([
            'id' => 'orders-calendar',
            'events' => [['title' => 'Order', 'start' => '2026-08-18']],
        ]);

        $this->assertStringContainsString('id="orders-calendar"', $html);
        $this->assertStringContainsString('cinghie-adminlte-calendar', $html);
        $this->assertArrayHasKey(CalendarAsset::class, \Yii::$app->view->assetBundles);
        $this->assertArrayHasKey(CalendarPrintAsset::class, \Yii::$app->view->assetBundles);
        $this->assertSame('print', \Yii::$app->view->assetBundles[CalendarPrintAsset::class]->cssOptions['media'] ?? null);
        $this->assertStringContainsString('fullCalendar', $this->getRegisteredJs());
    }

    public function testYiiRouteEventUrlIsNormalized(): void
    {
        Calendar::widget([
            'events' => [[
                'title' => 'Project',
                'start' => '2026-08-18',
                'url' => ['/project/view', 'id' => 42],
            ]],
        ]);

        $this->assertStringContainsString('/project/view?id=42', $this->getRegisteredJs());
    }

    public function testUnsafeEventUrlsAndColorsAreRemovedFromJavascript(): void
    {
        Calendar::widget([
            'id' => 'safe-calendar',
            'events' => [[
                'title' => '</script><script>alert(1)</script>',
                'start' => '2026-08-18',
                'url' => 'javascript:alert(1)',
                'color' => 'red; background:url(javascript:alert(1))',
            ]],
        ]);

        $js = $this->getRegisteredJs();
        $this->assertStringNotContainsString('javascript:alert(1)', $js);
        $this->assertStringNotContainsString('</script><script>', $js);
        $this->assertStringContainsString('\\u003C/script\\u003E', $js);
    }

    public function testClientOptionsCannotOverrideSanitizedEvents(): void
    {
        Calendar::widget([
            'events' => [[
                'title' => 'Safe event',
                'start' => '2026-08-18',
            ]],
            'clientOptions' => [
                'events' => [[
                    'title' => 'Injected event',
                    'url' => 'javascript:alert(1)',
                ]],
            ],
        ]);

        $js = $this->getRegisteredJs();
        $this->assertStringContainsString('Safe event', $js);
        $this->assertStringNotContainsString('Injected event', $js);
        $this->assertStringNotContainsString('javascript:alert(1)', $js);
    }

    public function testInvalidExternalEventColorIsNotRenderedInline(): void
    {
        $html = Calendar::widget([
            'showExternalEvents' => true,
            'externalEvents' => [[
                'title' => 'Unsafe color',
                'color' => 'red; background-image:url(javascript:alert(1))',
            ]],
        ]);

        $this->assertStringContainsString('Unsafe color', $html);
        $this->assertStringNotContainsString('background-image', $html);
        $this->assertStringNotContainsString('javascript:alert(1)', $html);
    }

    public function testExternalEventsAreEncoded(): void
    {
        $html = Calendar::widget([
            'showExternalEvents' => true,
            'externalEventsTitle' => '<script>bad()</script>',
            'externalEvents' => [['title' => '<img src=x onerror=alert(1)>', 'color' => '#3c8dbc']],
        ]);

        $this->assertStringNotContainsString('<script>bad()</script>', $html);
        $this->assertStringContainsString('&lt;script&gt;bad()&lt;/script&gt;', $html);
        $this->assertStringNotContainsString('<img src=x onerror=alert(1)>', $html);
        $this->assertStringContainsString('&lt;img src=x onerror=alert(1)&gt;', $html);
        $this->assertStringContainsString('external-event', $html);
    }

    public function testInvalidCollectionsAreRejected(): void
    {
        foreach (['events', 'clientOptions', 'options', 'externalEvents'] as $property) {
            try {
                Calendar::widget([$property => 'invalid']);
                $this->fail('Expected InvalidConfigException for Calendar::' . $property . '.');
            } catch (InvalidConfigException $exception) {
                $this->assertStringContainsString($property, $exception->getMessage());
            }
        }
    }

    private function getRegisteredJs(): string
    {
        $registered = [];
        foreach ((array) \Yii::$app->view->js as $scripts) {
            if (is_array($scripts)) {
                foreach ($scripts as $script) {
                    $registered[] = (string) $script;
                }
            } elseif ($scripts !== null) {
                $registered[] = (string) $scripts;
            }
        }

        return implode("\n", $registered);
    }
}
