Box Examples
=======================

## Box

Default Values:
```
<?php use cinghie\adminlte\widgets\Box; ?>

<!-- Box -->
<?= Box::widget() ?>
```

Custom Values:
```
<?php use cinghie\adminlte\widgets\Box; ?>

<!-- Box -->
<?= Box::widget([
    'buttonLeftTitle' => 'Place New Order',
    'buttonRightTitle' => 'View All Orders',
    'buttonLeftLink' => 'javascript:void(0)',
    'buttonRightLink' => 'javascript:void(0)',
    'columns' => $columns,
    'dataProvider' => $dataProvider,
    'type' => 'box-info',
    'title' => 'Box Title',
]) ?>
```
