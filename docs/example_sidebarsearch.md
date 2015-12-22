Sidebar Search Example
=======================

## Default Value

```
<?php use cinghie\adminlte\widgets\SidebarSearch; ?>

<!-- sidebar search form -->
<?= SidebarSearch::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\SidebarSearch; ?>

<!-- sidebar search form -->
<?= SidebarSearch::widget([
    'placeholder' => Yii::t('app', 'Search')
]) ?>
```
