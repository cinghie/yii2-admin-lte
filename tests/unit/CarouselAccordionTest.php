<?php

namespace cinghie\adminlte\tests\unit;

use cinghie\adminlte\tests\TestCase;
use cinghie\adminlte\widgets\Accordion;
use cinghie\adminlte\widgets\Carousel;
use yii\base\InvalidConfigException;

class CarouselAccordionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplication();
    }

    public function testCarouselRendersBootstrapStructure(): void
    {
        $html = Carousel::widget([
            'id' => 'demo-carousel',
            'items' => [
                ['content' => 'First', 'caption' => 'First slide'],
                ['content' => 'Second'],
            ],
        ]);

        $this->assertStringContainsString('id="demo-carousel"', $html);
        $this->assertStringContainsString('cinghie-adminlte-carousel', $html);
        $this->assertStringContainsString('carousel-indicators', $html);
        $this->assertStringContainsString('carousel-inner', $html);
        $this->assertStringContainsString('left carousel-control', $html);
        $this->assertStringContainsString('right carousel-control', $html);
    }

    public function testCarouselEncodesContentCaptionAndControlsByDefault(): void
    {
        $html = Carousel::widget([
            'controls' => ['<script>prev()</script>', '<img src=x onerror=alert(1)>'],
            'items' => [[
                'content' => '<img src=x onerror=alert(1)>',
                'caption' => '<script>alert(2)</script>',
            ]],
        ]);

        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringNotContainsString('<img src=x onerror=alert(1)>', $html);
        $this->assertStringContainsString('&lt;img src=x onerror=alert(1)&gt;', $html);
        $this->assertStringContainsString('&lt;script&gt;alert(2)&lt;/script&gt;', $html);
        $this->assertStringContainsString('&lt;script&gt;prev()&lt;/script&gt;', $html);
    }

    public function testCarouselAllowsExplicitTrustedHtml(): void
    {
        $html = Carousel::widget([
            'items' => [[
                'content' => '<img src="/slide.jpg" alt="Slide">',
                'caption' => '<strong>Trusted caption</strong>',
                'encodeContent' => false,
                'encodeCaption' => false,
            ]],
        ]);

        $this->assertStringContainsString('<img src="/slide.jpg" alt="Slide">', $html);
        $this->assertStringContainsString('<strong>Trusted caption</strong>', $html);
    }

    public function testCarouselRejectsInvalidItemsAndControls(): void
    {
        try {
            Carousel::widget(['items' => 'invalid']);
            $this->fail('Invalid items must be rejected.');
        } catch (InvalidConfigException $exception) {
            $this->assertStringContainsString('items', $exception->getMessage());
        }

        $this->expectException(InvalidConfigException::class);
        Carousel::widget(['controls' => ['previous'], 'items' => []]);
    }

    public function testAccordionRendersContextualPanelsAndActiveItem(): void
    {
        $html = Accordion::widget([
            'id' => 'demo-accordion',
            'items' => [
                [
                    'label' => 'Default item',
                    'content' => 'First body',
                    'contentOptions' => ['class' => 'in'],
                ],
                [
                    'label' => 'Danger item',
                    'content' => 'Second body',
                    'type' => 'danger',
                ],
                [
                    'label' => 'Success item',
                    'content' => 'Third body',
                    'type' => 'success',
                ],
            ],
        ]);

        $this->assertStringContainsString('id="demo-accordion"', $html);
        $this->assertStringContainsString('cinghie-adminlte-accordion', $html);
        $this->assertStringContainsString('panel-default', $html);
        $this->assertStringContainsString('panel-danger', $html);
        $this->assertStringContainsString('panel-success', $html);
        $this->assertMatchesRegularExpression('/class="[^"]*\bin\b[^"]*\bpanel-collapse\b[^"]*\bcollapse\b[^"]*"/', $html);
        $this->assertStringContainsString('data-parent="#demo-accordion"', $html);
    }

    public function testAccordionEncodesLabelsContentListsAndFooterByDefault(): void
    {
        $html = Accordion::widget([
            'items' => [[
                'label' => '<script>label()</script>',
                'content' => ['<img src=x onerror=alert(1)>'],
                'footer' => '<script>footer()</script>',
            ]],
        ]);

        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringNotContainsString('<img src=x onerror=alert(1)>', $html);
        $this->assertStringContainsString('&lt;script&gt;label()&lt;/script&gt;', $html);
        $this->assertStringContainsString('&lt;img src=x onerror=alert(1)&gt;', $html);
        $this->assertStringContainsString('&lt;script&gt;footer()&lt;/script&gt;', $html);
    }

    public function testAccordionAllowsExplicitTrustedContent(): void
    {
        $html = Accordion::widget([
            'items' => [[
                'label' => 'Trusted',
                'content' => ['<p><strong>Trusted HTML</strong></p>'],
                'footer' => '<em>Footer</em>',
                'encodeContent' => false,
                'encodeFooter' => false,
            ]],
        ]);

        $this->assertStringContainsString('<p><strong>Trusted HTML</strong></p>', $html);
        $this->assertStringContainsString('<em>Footer</em>', $html);
    }

    public function testAccordionRejectsInvalidPanelType(): void
    {
        $this->expectException(InvalidConfigException::class);
        Accordion::widget([
            'items' => [[
                'label' => 'Bad',
                'content' => 'Body',
                'type' => 'not-a-bootstrap-type',
            ]],
        ]);
    }
}
