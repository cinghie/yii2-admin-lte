<?php

namespace cinghie\adminlte\tests\unit;

use cinghie\adminlte\CalendarAsset;
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

    public function testRendersCalendarAndRegistersDedicatedAsset(): void
    {
        $html = Calendar::widget([
            'id' => 'orders-calendar',
            'events' => [
                ['title' => 'Order', 'start' => '2026-08-18'],
            ],
        ]);

        $this->assertStringContainsString('id="orders-calendar"', $html);
        $this->assertStringContainsString('cinghie-adminlte-calendar', $html);
        $this->assertArrayHasKey(CalendarAsset::class, \Yii::$app->view->assetBundles);
        $this->assertStringContainsString('fullCalendar', implode("\n", \Yii::$app->view->js[3] ?? []));
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

        $js = implode("\n", \Yii::$app->view->js[3] ?? []);
        $this->assertStringNotContainsString('javascript:alert(1)', $js);
        $this->assertStringNotContainsString('</script><script>', $js);
        $this->assertStringContainsString('\\u003C/script\\u003E', $js);
    }

    public function testExternalEventsAreEncoded(): void
    {
        $html = Calendar::widget([
            'showExternalEvents' => true,
            'externalEventsTitle' => '<script>bad()</script>',
            'externalEvents' => [
                ['title' => '<img src=x onerror=alert(1)>', 'color' => '#3c8dbc'],
            ],
        ]);

        $this->assertStringNotContainsString('<script>bad()</script>', $html);
        $this->assertStringContainsString('&lt;script&gt;bad()&lt;/script&gt;', $html);
        $this->assertStringNotContainsString('<img src=x onerror=alert(1)>', $html);
        $this->assertStringContainsString('&lt;img src=x onerror=alert(1)&gt;', $html);
        $this->assertStringContainsString('external-event', $html);
    }

    public function testInvalidCollectionsAreRejected(): void
    {
        $this->expectException(InvalidConfigException::class);
        Calendar::widget(['events' => 'invalid']);
    }
}
