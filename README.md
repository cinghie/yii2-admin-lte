# Yii2 AdminLTE

![License](https://img.shields.io/packagist/l/cinghie/yii2-admin-lte.svg)
![Latest Stable Version](https://img.shields.io/github/release/cinghie/yii2-admin-lte.svg)
![Latest Release Date](https://img.shields.io/github/release-date/cinghie/yii2-admin-lte.svg)
![Latest Commit](https://img.shields.io/github/last-commit/cinghie/yii2-admin-lte.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/cinghie/yii2-admin-lte.svg)](https://packagist.org/packages/cinghie/yii2-admin-lte)

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

Widgets Examples
-----------------

[Alert](docs/example_alert.md)  
[Box](docs/example_box.md)  
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

Suite covers Yii2 best practices (widgets/assets/`use` imports), Invoice encoding & API, Box content/grid modes, and smoke tests for Alert / Simplebox / Footer / Navbar / Sidebar widgets.
