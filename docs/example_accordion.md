# Accordion

`cinghie\adminlte\widgets\Accordion` renders the Bootstrap 3 collapsible accordion shown in AdminLTE 2 and adds AdminLTE/Bootstrap contextual panel types with safe output defaults.

## Basic usage

```php
use cinghie\adminlte\widgets\Accordion;

echo Accordion::widget([
    'items' => [
        [
            'label' => 'Collapsible Group Item #1',
            'content' => 'First panel content',
            'contentOptions' => ['class' => 'in'],
        ],
        [
            'label' => 'Collapsible Group Danger',
            'content' => 'Danger panel content',
            'type' => 'danger',
        ],
        [
            'label' => 'Collapsible Group Success',
            'content' => 'Success panel content',
            'type' => 'success',
        ],
    ],
]);
```

Supported panel types are `default`, `primary`, `success`, `info`, `warning`, and `danger`.

## Key-value syntax

The standard Yii Bootstrap collapse syntax is supported:

```php
echo Accordion::widget([
    'items' => [
        'Introduction' => 'First panel content',
        'Second panel' => [
            'content' => 'Second panel content',
            'type' => 'info',
        ],
    ],
]);
```

## List content and footer

Array content renders as a Bootstrap list group. Footer text is also supported:

```php
echo Accordion::widget([
    'items' => [[
        'label' => 'Files',
        'content' => ['Document A', 'Document B'],
        'footer' => '2 files',
    ]],
]);
```

## Trusted HTML

Labels use Yii Bootstrap's `encodeLabels = true` default. Content, list entries and footers are additionally encoded by this widget.

For application-generated or sanitized HTML, encoding can be disabled explicitly for an item:

```php
echo Accordion::widget([
    'items' => [[
        'label' => 'Details',
        'content' => '<p><strong>Trusted HTML</strong></p>',
        'footer' => '<em>Trusted footer</em>',
        'encodeContent' => false,
        'encodeFooter' => false,
    ]],
]);
```

Do not disable encoding for untrusted user input.

## Options

The widget inherits `yii\bootstrap\Collapse` options and adds:

- `encodeContent` — encode scalar content and list entries by default; defaults to `true`.
- `encodeFooters` — encode footers by default; defaults to `true`.
- item `type` — contextual Bootstrap panel type.
- item `encodeContent` — override content encoding for one panel.
- item `encodeFooter` — override footer encoding for one panel.

Standard options such as `encodeLabels`, `autoCloseItems`, `itemToggleOptions`, `options`, `contentOptions`, and item `options` remain available.

Set `autoCloseItems` to `false` if multiple panels may remain open simultaneously.

The Bootstrap collapse plugin asset is registered by `yii2-bootstrap`; no additional AdminLTE asset bundle is required.
