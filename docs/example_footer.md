Footer Example
===============

## Default Value

```
<?php use cinghie\adminlte\widgets\Footer; ?>

<!-- sidebar user panel -->
<?= Footer::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\SidebarSearch; ?>

<!-- sidebar user panel -->
<?= Footer::widget([
    'copyright_date_start' => '2014',
	'copyright_date_end' => 2015, // if null, echo the current year
    'copyright_link' => 'http://www.almsaeedstudio.com',
    'copyright_text' => 'Almsaeed Studio',
    'version' => '2.3.1'
]) ?>
```
