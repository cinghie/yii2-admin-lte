Simplebox Examples
=======================

Info-box widgets for dashboard counters (AdminLTE 2).

> Property name is **`bgclass`** (not `bg-class`).  
> Prefer **`wrapperClass`-style layout via `$class`** for the outer column (`col-md-3 …`).

## Simplebox1

Basic icon + text + number.

Default Values:
```
<?php use cinghie\adminlte\widgets\Simplebox1; ?>

<?= Simplebox1::widget() ?>
```

Custom Values:
```
<?php use cinghie\adminlte\widgets\Simplebox1; ?>

<?= Simplebox1::widget([
    'bgclass' => 'bg-aqua',
    'class' => 'col-md-3 col-sm-6 col-xs-12',
    'icon' => 'fa fa-envelope-o',
    'title' => 'Messages',
    'subtitle' => '1,410',
]) ?>
```

| Property | Default |
|----------|---------|
| `bgclass` | `bg-aqua` |
| `class` | `col-md-3 col-sm-6 col-xs-12` |
| `icon` | `fa fa-envelope-o` |
| `title` | `Messages` |
| `subtitle` | `1,410` |

## Simplebox2

Info-box with progress bar and description.

Default Values:
```
<?php use cinghie\adminlte\widgets\Simplebox2; ?>

<?= Simplebox2::widget() ?>
```

Custom Values:
```
<?php use cinghie\adminlte\widgets\Simplebox2; ?>

<?= Simplebox2::widget([
    'bgclass' => 'bg-aqua',
    'class' => 'col-md-3 col-sm-6 col-xs-12',
    'description' => '70% Increase in 30 Days',
    'icon' => 'fa fa-envelope-o',
    'progress' => '70',
    'title' => 'Messages',
    'subtitle' => '1,410',
]) ?>
```

| Property | Default |
|----------|---------|
| `bgclass` | `bg-aqua` |
| `class` | `col-md-3 col-sm-6 col-xs-12` |
| `description` | (set in widget) |
| `icon` | `fa fa-envelope-o` |
| `progress` | progress % |
| `title` / `subtitle` | labels / number |

## Simplebox3

Small box with footer link (used by CRM dashboard via `cinghie\crm\widgets\SmallBox`).

Default Values:
```
<?php use cinghie\adminlte\widgets\Simplebox3; ?>

<?= Simplebox3::widget() ?>
```

Custom Values:
```
<?php use cinghie\adminlte\widgets\Simplebox3; ?>

<?= Simplebox3::widget([
    'bgclass' => 'bg-aqua',
    'class' => 'col-md-3 col-sm-6 col-xs-12',
    'description' => 'More info',
    'icon' => 'fa fa-shopping-cart',
    'link' => ['/order/index'],
    'title' => '150',
    'subtitle' => 'New Orders',
]) ?>
```

| Property | Default |
|----------|---------|
| `bgclass` | `bg-aqua` |
| `class` | `col-md-3 col-sm-6 col-xs-12` |
| `description` | `More info` |
| `icon` | `fa fa-shopping-cart` |
| `link` | `#` |
| `title` / `subtitle` | number / label |
