Simplebox Examples
=======================

## Simplebox1

Default Values:
```
<?php use cinghie\adminlte\widgets\Simplebox1; ?>

<!-- Simplebox1 -->
<?= Simplebox1::widget() ?>
```

Custom Values:
```
<?php use cinghie\adminlte\widgets\Simplebox1; ?>

<!--simplebox1 -->
<?= Simplebox1::widget([
    'bg-class' => 'bg-aqua',
    'class' => 'col-md-3 col-sm-6 col-xs-12',
    'icon' => 'fa fa-envelope-o',
    'title' => 'Messages',
    'subtitle' => '1,410'
]) ?>
```

## Simplebox2

Default Values:
```
<?php use cinghie\adminlte\widgets\Simplebox2; ?>

<!-- Simplebox2 -->
<?= Simplebox2::widget() ?>
```

Custom Values:
```
<?php use cinghie\adminlte\widgets\Simplebox2; ?>

<!-- Simplebox2 -->
<?= Simplebox2::widget([
    'bg-class' => 'bg-aqua',
    'class' => 'col-md-3 col-sm-6 col-xs-12',
    'description' => '70% Increase in 30 Days',
    'icon' => 'fa fa-envelope-o',
    'progress' => '70',
    'title' => 'Messages',
    'subtitle' => '1,410'
]) ?>
```

## Simplebox3

Default Values:
```
<?php use cinghie\adminlte\widgets\Simplebox3; ?>

<!-- Simplebox3 -->
<?= Simplebox3::widget() ?>
```

Custom Values:
```
<?php use cinghie\adminlte\widgets\Simplebox1; ?>

<!-- Simplebox3 -->
<?= Simplebox3::widget([
    'bg-class' => 'bg-aqua',
    'class' => 'col-md-3 col-sm-6 col-xs-12',
    'description' => 'More info',
    'icon' => 'fa fa-shopping-cart',
    'title' => '150',
    'subtitle' => 'New Orders'
]) ?>
```
