# Yii2 AdminLTE
Asset Bundle to include AdminLTE on your Yii 2 project: https://github.com/almasaeed2010/AdminLTE/

Installation
-----------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require cinghie/yii2-admin-lte "^1.5.4"
```

or add this line to the require section of your `composer.json` file.

```
"cinghie/yii2-admin-lte": "^1.5.4"
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
[Footer](docs/example_footer.md)  
[Navbar Button](docs/example_navbarbutton.md)  
[Navbar Logo](docs/example_navbarlogo.md)  
[Navbar User](docs/example_navbaruser.md)  
[Sidebar Menu](docs/example_sidebarmenu.md)  
[Sidebar Search](docs/example_sidebarsearch.md)  
[Sidebar Toggle](docs/example_sidebartoggle.md)  
[Sidebar User](docs/example_sidebaruser.md)  
[Simplebox](docs/example_simplebox.md)  
