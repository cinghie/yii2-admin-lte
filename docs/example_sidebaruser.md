Sidebar User Example
=======================

## Default Value

```
<?php use cinghie\adminlte\widgets\SidebarUser; ?>

<!-- sidebar user panel -->
<?= SidebarUser::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\SidebarSearch; ?>

<!-- sidebar user panel -->
<?= SidebarUser::widget([
    'username' => 'My Username',
    'userimg' => 'https://cdn0.iconfinder.com/data/icons/user-pictures/100/matureman1-2-128.png'
]) ?>
```
