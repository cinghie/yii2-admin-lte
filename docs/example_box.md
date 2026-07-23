Box Examples
=======================

AdminLTE 2 box widget with two modes:

- **Content** — custom HTML via `begin()` / `end()`, or `$body` / `$footer`
- **Grid** — Kartik `GridView` inside the box when `$dataProvider` is set

> **Important:** do **not** pass a CSS wrapper as config key `class`.  
> Yii uses `class` for the PHP class name in `widget()` / `begin()`.  
> Use **`wrapperClass`** instead (legacy CSS `class` is remapped automatically when it looks like a CSS class).

## Content mode (begin / end)

```
<?php use cinghie\adminlte\widgets\Box; ?>

<?php Box::begin([
    'type' => 'info',              // or box-info, warning, success, primary, danger, default
    'title' => 'Import Data',
    'titleIcon' => 'fa fa-upload',
    'wrapperClass' => null,        // null = no column wrapper
    'withBorder' => true,
    'collapsible' => false,        // default false in content mode
    'removable' => false,
    'bodyOptions' => ['style' => 'padding: 25px 25px 0 25px'],
    'footer' => '<button class="btn btn-info" type="button">Save</button>',
    'encodeFooter' => false,
]); ?>
    <p>Custom body HTML here.</p>
<?php Box::end(); ?>
```

## Content mode (widget + body)

```
<?= Box::widget([
    'type' => 'success',
    'title' => 'Notes',
    'titleIcon' => 'fa fa-info-circle',
    'body' => 'Plain text body (HTML-encoded by default).',
    'encodeBody' => true,
]) ?>
```

## Grid mode (dashboard tables)

Requires `$dataProvider` and `$columns`. Optional footer buttons.

```
<?php use cinghie\adminlte\widgets\Box; ?>

<?= Box::widget([
    'wrapperClass' => 'col-md-6 col-sm-12 col-xs-12', // preferred over "class"
    'type' => 'box-info',
    'title' => 'Last Orders',
    'titleIcon' => 'fa fa-shopping-cart',
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'buttonLeftTitle' => 'Place New Order',
    'buttonLeftLink' => ['/order/create'],
    'buttonLeftType' => 'info',          // optional; defaults to box type
    'buttonRightTitle' => 'View All Orders',
    'buttonRightLink' => ['/order/index'],
    'buttonRightType' => 'default',
    'collapsible' => true,               // default true in grid mode
    'removable' => true,
]) ?>
```

## Main properties

| Property | Default | Notes |
|----------|---------|--------|
| `type` | `info` | `info\|warning\|success\|primary\|danger\|default` or `box-*` |
| `title` / `titleIcon` | `null` | Header title and FA icon |
| `encodeTitle` | `true` | Encode title text |
| `body` / `encodeBody` | `''` / `true` | Used when not capturing begin/end content |
| `footer` / `encodeFooter` | `null` / `true` | Content footer (HTML if `encodeFooter=false`) |
| `wrapperClass` | `null` | Column wrapper; grid defaults to `col-md-6 col-sm-12 col-xs-12` |
| `class` | `null` | Legacy CSS wrapper (prefer `wrapperClass`) |
| `dataProvider` | `null` | If set → grid mode |
| `columns` | `null` | Required in grid mode |
| `withBorder` | `true` | `box-header with-border` |
| `collapsible` / `removable` | `null` | Auto: on in grid, off in content |
| `options` / `headerOptions` / `bodyOptions` / `footerOptions` | `[]` | Extra HTML options |

## CRM alias

`cinghie\crm\widgets\Box` extends this widget directly. For AdminLTE 3 / Bootstrap 4 panels use `cinghie\adminlte3\widgets\Card` instead.
