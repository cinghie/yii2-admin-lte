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

Changelog
-----------------

<ul>
  <li>Version 1.3.0 - Adding Alert and Menù widget from https://github.com/dmstr/yii2-adminlte-asset/tree/master/widgets</li>
  <li>Version 1.2.1 - Update folder admin-lte/dist</li>
  <li>Version 1.2.0 - Added ionicons</li>
  <li>Version 1.1.2 - Purge code</li>
  <li>Version 1.1.1 - Fixing AdminLTEMinifyAsset for Font Awesome</li>
  <li>Version 1.1.0 - Adding AdminLTE Minify CSS and JS</li>
  <li>Version 1.0.1 - Updates CSS and JS Folder</li>
  <li>Version 1.0 - Initial Release</li>
</ul>
