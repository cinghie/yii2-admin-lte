<?php

namespace cinghie\adminlte\tests\unit;

use ReflectionMethod;
use Yii;
use cinghie\adminlte\tests\TestCase;
use cinghie\adminlte\widgets\Box;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

/**
 * AdminLTE 2 Box widget (content + grid modes).
 */
class BoxWidgetTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		$this->mockApplication();
	}

	public function testContentModeBeginEnd(): void
	{
		ob_start();
		Box::begin([
			'type' => 'info',
			'title' => 'Import',
			'titleIcon' => 'fa fa-upload',
			'footer' => '<button type="button">Go</button>',
			'encodeFooter' => false,
		]);
		echo '<p>Body HTML</p>';
		Box::end();
		$html = ob_get_clean();

		$this->assertStringContainsString('box-info', $html);
		$this->assertStringContainsString('cinghie-adminlte-box', $html);
		$this->assertStringContainsString('Import', $html);
		$this->assertStringContainsString('fa fa-upload', $html);
		$this->assertStringContainsString('<p>Body HTML</p>', $html);
		$this->assertStringContainsString('<button type="button">Go</button>', $html);
		$this->assertStringNotContainsString('data-widget="collapse"', $html);
	}

	public function testContentModeEncodesBodyByDefault(): void
	{
		$html = Box::widget([
			'type' => 'warning',
			'title' => 'T',
			'body' => '<script>x</script>',
		]);
		$this->assertStringContainsString(Html::encode('<script>x</script>'), $html);
		$this->assertStringNotContainsString('<script>x</script>', $html);
	}

	public function testNormalizeConfigRemapsCssClassToWrapperClass(): void
	{
		$ref = new ReflectionMethod(Box::class, 'normalizeConfig');
		$ref->setAccessible(true);
		$out = $ref->invoke(null, ['class' => 'col-md-4', 'title' => 'T']);
		$this->assertSame('col-md-4', $out['wrapperClass']);
		$this->assertArrayNotHasKey('class', $out);

		$fqcn = $ref->invoke(null, ['class' => Box::class]);
		$this->assertSame(Box::class, $fqcn['class']);
	}

	public function testWrapperClassFromLegacyClassConfig(): void
	{
		$html = Box::widget([
			'class' => 'col-md-4',
			'title' => 'Wrapped',
			'body' => 'x',
		]);
		$this->assertStringContainsString('col-md-4', $html);
		$this->assertStringContainsString('Wrapped', $html);
	}

	public function testTypeAcceptsBoxPrefix(): void
	{
		$html = Box::widget([
			'type' => 'box-success',
			'title' => 'OK',
			'body' => 'ok',
		]);
		$this->assertStringContainsString('box-success', $html);
	}

	public function testGridModeRequiresColumns(): void
	{
		if (!class_exists(\kartik\grid\GridView::class)) {
			$this->markTestSkipped('kartik-v/yii2-grid not installed');
		}
		$this->expectException(\yii\base\InvalidConfigException::class);
		Box::widget([
			'dataProvider' => new ArrayDataProvider(['allModels' => []]),
			'columns' => null,
			'title' => 'Grid',
		]);
	}

	public function testGridModeRendersWithProvider(): void
	{
		if (!class_exists(\kartik\grid\GridView::class)) {
			$this->markTestSkipped('kartik-v/yii2-grid not installed');
		}
		$html = Box::widget([
			'dataProvider' => new ArrayDataProvider([
				'allModels' => [['id' => 1, 'name' => 'A']],
				'pagination' => false,
			]),
			'columns' => ['id', 'name'],
			'title' => 'Last',
			'buttonLeftTitle' => 'New',
			'buttonLeftLink' => '/create',
			'buttonRightTitle' => 'All',
			'buttonRightLink' => '/index',
			'type' => 'box-primary',
		]);
		$this->assertStringContainsString('box-primary', $html);
		$this->assertStringContainsString('Last', $html);
		$this->assertStringContainsString('data-widget="collapse"', $html);
		$this->assertStringContainsString('New', $html);
		$this->assertStringContainsString('All', $html);
		$this->assertStringContainsString('col-md-6', $html);
	}
}
