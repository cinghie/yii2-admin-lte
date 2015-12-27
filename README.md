# Yii2 AdminLTE
Asset Bundle to include AdminLTE on your Yii 2 project:<br>
https://github.com/almasaeed2010/AdminLTE/

Installation
-----------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require cinghie/yii2-admin-lte "*"
```

or add this line to the require section of your `composer.json` file.

```
"cinghie/yii2-admin-lte": "*"
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

[Alert] (docs/example_alert.md)

[Footer] (docs/example_footer.md)

[Logo] (docs/example_logo.md)

[Sidebar Menu] (docs/example_sidebarmenu.md)

[Sidebar Search] (docs/example_sidebarsearch.md)

[Sidebar User] (docs/example_sidebaruser.md)

Changelog
-----------------

<ul>
  <li>Version 1.3.3 - Adding Widget Footer</li>
  <li>Version 1.3.2 - Adding Widgets Sidebar Search and User</li>
  <li>Version 1.3.1 - Some Fix and Adding doc examples</li>
  <li>Version 1.3.0 - Adding Alert and Menù widget from https://github.com/dmstr/yii2-adminlte-asset/tree/master/widgets</li>
  <li>Version 1.2.1 - Update folder admin-lte/dist</li>
  <li>Version 1.2.0 - Added ionicons</li>
  <li>Version 1.1.2 - Purge code</li>
  <li>Version 1.1.1 - Fixing AdminLTEMinifyAsset for Font Awesome</li>
  <li>Version 1.1.0 - Adding AdminLTE Minify CSS and JS</li>
  <li>Version 1.0.1 - Updates CSS and JS Folder</li>
  <li>Version 1.0 - Initial Release</li>
</ul>
