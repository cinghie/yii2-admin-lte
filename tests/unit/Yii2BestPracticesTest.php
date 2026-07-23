<?php

namespace cinghie\adminlte\tests\unit;

use cinghie\adminlte\AdminLTEAsset;
use cinghie\adminlte\AdminLTEMinifyAsset;
use cinghie\adminlte\tests\TestCase;
use cinghie\adminlte\widgets\Alert;
use cinghie\adminlte\widgets\Box;
use cinghie\adminlte\widgets\ContentHeader;
use cinghie\adminlte\widgets\Footer;
use cinghie\adminlte\widgets\GridView;
use cinghie\adminlte\widgets\Invoice;
use cinghie\adminlte\widgets\NavbarLogo;
use cinghie\adminlte\widgets\SidebarToggle;
use cinghie\adminlte\widgets\Simplebox3;
use yii\bootstrap\Widget;
use yii\web\AssetBundle;

/**
 * Yii2 guide patterns used by the AdminLTE package.
 *
 * @see https://www.yiiframework.com/doc/guide/2.0/en/structure-assets
 * @see https://www.yiiframework.com/doc/guide/2.0/en/security-best-practices
 */
class Yii2BestPracticesTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		$this->mockApplication();
	}

	public function testCoreWidgetsExtendBootstrapWidget(): void
	{
		foreach ([
			Alert::class,
			Box::class,
			ContentHeader::class,
			Footer::class,
			Invoice::class,
			NavbarLogo::class,
			SidebarToggle::class,
			Simplebox3::class,
		] as $class) {
			$this->assertTrue(
				is_subclass_of($class, Widget::class),
				$class . ' must extend yii\\bootstrap\\Widget'
			);
		}
	}

	public function testGridViewExtendsKartikWhenAvailable(): void
	{
		if (!class_exists(\kartik\grid\GridView::class)) {
			$this->markTestSkipped('kartik-v/yii2-grid not installed');
		}
		$this->assertTrue(is_subclass_of(GridView::class, \kartik\grid\GridView::class));
	}

	public function testAssetBundlesUseSourcePath(): void
	{
		foreach ([AdminLTEAsset::class, AdminLTEMinifyAsset::class] as $class) {
			if (!class_exists($class)) {
				continue;
			}
			$bundle = new $class();
			$this->assertInstanceOf(AssetBundle::class, $bundle);
			$this->assertNotEmpty($bundle->sourcePath, $class . ' should define sourcePath');
			$this->assertNotEmpty($bundle->depends, $class . ' should declare depends');
		}
	}

	public function testAdminLteAssetRejectsInvalidSkin(): void
	{
		$bundle = new AdminLTEAsset();
		$bundle->skin = 'not-a-skin';
		$this->expectException(\yii\base\Exception::class);
		$bundle->init();
	}

	/**
	 * `use Yii;` in non-namespaced files is a no-op / warning.
	 * Namespaced files may import Yii only when they reference Yii::.
	 */
	public function testUseYiiImportIsNotImproperOrUnused(): void
	{
		$root = dirname(__DIR__, 2);
		$useYii = '/^use\s+\\\\?Yii\s*;/m';
		$namespace = '/^namespace\s+/m';
		$yiiCall = '/(?<![\w\\\\])Yii::/';

		$improper = [];
		$unused = [];

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file) {
			/** @var \SplFileInfo $file */
			if (!$file->isFile() || $file->getExtension() !== 'php') {
				continue;
			}

			$rel = str_replace('\\', '/', substr($file->getPathname(), strlen($root) + 1));
			if (str_starts_with($rel, 'tests/') || str_starts_with($rel, 'vendor/')) {
				continue;
			}

			$src = file_get_contents($file->getPathname());
			if ($src === false || !preg_match($useYii, $src)) {
				continue;
			}

			$hasNamespace = (bool) preg_match($namespace, $src);
			$usesYii = (bool) preg_match($yiiCall, $src);

			if (!$hasNamespace) {
				$improper[] = $rel;
			} elseif (!$usesYii) {
				$unused[] = $rel;
			}
		}

		$this->assertSame(
			[],
			$improper,
			'Do not use `use Yii;` in non-namespaced PHP: ' . implode(', ', $improper)
		);
		$this->assertSame(
			[],
			$unused,
			'`use Yii;` is unused (no Yii:: reference) in: ' . implode(', ', $unused)
		);
	}

	/**
	 * Top-level `use` imports must be alphabetically sorted (case-sensitive).
	 *
	 * @see https://www.php-fig.org/psr/psr-12/#3-declare-statements-namespace-and-import-statements
	 */
	public function testUseStatementsAreAlphabeticallySortedCaseSensitive(): void
	{
		$root = dirname(__DIR__, 2);
		$violations = [];
		// Commerce-coupled widget kept out until package optional-deps are cleaned up
		$skip = [
			'widgets/Timeline.php',
		];

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS)
		);

		foreach ($iterator as $file) {
			/** @var \SplFileInfo $file */
			if (!$file->isFile() || $file->getExtension() !== 'php') {
				continue;
			}

			$rel = str_replace('\\', '/', substr($file->getPathname(), strlen($root) + 1));
			if (str_starts_with($rel, 'tests/') || str_starts_with($rel, 'vendor/') || str_starts_with($rel, 'docs/')) {
				continue;
			}
			if (in_array($rel, $skip, true)) {
				continue;
			}

			$stmts = $this->extractTopLevelUseStatements($file->getPathname());
			if ($stmts === null || $stmts === []) {
				continue;
			}

			$expected = $stmts;
			usort($expected, [$this, 'compareUseStatements']);
			if ($stmts !== $expected) {
				$violations[] = $rel
					. "\n  actual:   " . implode(', ', $stmts)
					. "\n  expected: " . implode(', ', $expected);
			}
		}

		$this->assertSame(
			[],
			$violations,
			"Unsorted `use` imports (case-sensitive):\n" . implode("\n", $violations)
		);
	}

	public function testComposerAutoloadPsr4(): void
	{
		$composer = json_decode(
			file_get_contents(dirname(__DIR__, 2) . '/composer.json'),
			true,
			512,
			JSON_THROW_ON_ERROR
		);
		$this->assertSame(['cinghie\\adminlte\\' => ''], $composer['autoload']['psr-4'] ?? null);
		$this->assertArrayHasKey('cinghie\\adminlte\\tests\\', $composer['autoload-dev']['psr-4'] ?? []);
	}

	/**
	 * @return string[]|null
	 */
	private function extractTopLevelUseStatements(string $path): ?array
	{
		$lines = file($path, FILE_IGNORE_NEW_LINES);
		if ($lines === false) {
			return [];
		}

		$stmts = [];
		$started = false;

		foreach ($lines as $line) {
			if (preg_match('/^(abstract\s+|final\s+)?(class|interface|trait)\s+/', $line)) {
				break;
			}

			if (preg_match('/^use\s+/', $line)) {
				$started = true;
				if (str_contains($line, '{')) {
					return null;
				}
				if (!preg_match('/^use\s+(.+?)\s*;\s*$/', $line, $m)) {
					return null;
				}
				$stmts[] = $m[1];
				continue;
			}

			if ($started && trim($line) === '') {
				continue;
			}

			if ($started) {
				break;
			}
		}

		return $stmts;
	}

	private function compareUseStatements(string $a, string $b): int
	{
		$rank = static function (string $stmt): int {
			if (str_starts_with($stmt, 'function ')) {
				return 1;
			}
			if (str_starts_with($stmt, 'const ')) {
				return 2;
			}

			return 0;
		};

		$ra = $rank($a);
		$rb = $rank($b);
		if ($ra !== $rb) {
			return $ra <=> $rb;
		}

		return strcmp($a, $b);
	}
}
