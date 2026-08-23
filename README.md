# Yii2 AdminLTE

![License](https://img.shields.io/packagist/l/cinghie/yii2-admin-lte.svg)
![Latest Stable Version](https://img.shields.io/github/release/cinghie/yii2-admin-lte.svg)
![Latest Release Date](https://img.shields.io/github/release-date/cinghie/yii2-admin-lte.svg)
![Latest Commit](https://img.shields.io/github/last-commit/cinghie/yii2-admin-lte.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/cinghie/yii2-admin-lte.svg)](https://packagist.org/packages/cinghie/yii2-admin-lte)

> [!WARNING]
> ## Legacy package
>
> This package is based on **AdminLTE 2.x**, which is no longer actively maintained upstream.
>
> The package is therefore considered **legacy** and is maintained primarily for existing Yii 2 applications that still depend on AdminLTE 2.
>
> For new projects, consider using a solution based on **AdminLTE 3 / Bootstrap 4 or newer**: https://github.com/cinghie/yii2-adminlte3/  
>
> No migration to a newer AdminLTE major version is currently planned, as such a change would require significant backwards-incompatible changes.

Asset Bundle to include AdminLTE on your Yii 2 project: https://github.com/almasaeed2010/AdminLTE/

Installation
-----------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require cinghie/yii2-admin-lte "^1.5.5"
```

or add this line to the require section of your `composer.json` file.

```
"cinghie/yii2-admin-lte": "^1.5.5"
```

Configuration
-----------------

Add in the view for normal CSS and JS

```
use cinghie\adminlte\AdminLTEAsset;

AdminLTEAsset::register($this);
```

Add in the view for minify CSS and JS

```
use cinghie\adminlte\AdminLTEMinifyAsset;

AdminLTEMinifyAsset::register($this);
```

Reusable input widgets
-----------------

Bootstrap 3/AdminLTE 2 applications can reuse the package-owned input widgets without depending on a feature module such as `yii2-events`:

```php
use cinghie\adminlte\widgets\ColorPicker;
use cinghie\adminlte\widgets\DatePicker;
use cinghie\adminlte\widgets\DateTimePicker;

$form->field($model, 'color')->widget(ColorPicker::class);
$form->field($model, 'date')->widget(DatePicker::class);
$form->field($model, 'starts_at')->widget(DateTimePicker::class);
```

`ColorPicker` is self-contained: it keeps the HEX value as the submitted field and opens its suggested palette only on demand. `DatePicker` and `DateTimePicker` wrap Kartik's Bootstrap 3 date/time implementation; `kartik-v/yii2-widgets` is therefore a runtime dependency of this package so the exported date widgets work immediately for clean consumers.

Widgets Examples
-----------------

[Accordion](docs/example_accordion.md) — Bootstrap 3 collapsible panels with contextual AdminLTE styles and safe content defaults.  
[Alert](docs/example_alert.md)  
[Box](docs/example_box.md)  
[Calendar](docs/example_calendar.md) — FullCalendar 3 integration with Yii route URLs, dedicated assets, print support and optional AdminLTE draggable events.  
[Carousel](docs/example_carousel.md) — Bootstrap 3 carousel with indicators, controls and safe slide/caption defaults.  
[ColorPicker](widgets/ColorPicker.php) — reusable deferred HEX/palette input.  
[DatePicker](widgets/DatePicker.php) — reusable date-only picker.  
[DateTimePicker](widgets/DateTimePicker.php) — reusable date/time picker.  
[Content Header](docs/example_contentheader.md)  
[DataColumn](docs/example_datacolumn.md)  
[Footer](docs/example_footer.md)  
[GridView](docs/example_gridview.md)  
[Invoice](docs/example_invoice.md)  
[Mailbox Read](docs/example_mailboxread.md)  
[Navbar Button](docs/example_navbarbutton.md)  
[Navbar Logo](docs/example_navbarlogo.md)  
[Navbar User](docs/example_navbaruser.md)  
[Sidebar Menu](docs/example_sidebarmenu.md)  
[Sidebar Search](docs/example_sidebarsearch.md)  
[Sidebar Toggle](docs/example_sidebartoggle.md)  
[Sidebar User](docs/example_sidebaruser.md)  
[Simplebox](docs/example_simplebox.md)  
[Timeline](docs/example_timeline.md)  

Tests
-----------------

```
composer test
# or
vendor/bin/phpunit -c tests/phpunit.xml
```

Suite covers Yii2 best practices (widgets/assets/`use` imports), Calendar integration, Carousel/Accordion rendering and input hardening, Yii URL normalization, Invoice encoding & API, Box content/grid modes, reusable input-widget contracts, and smoke tests for Alert / Simplebox / Footer / Navbar / Sidebar widgets.
