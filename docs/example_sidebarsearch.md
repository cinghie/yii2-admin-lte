Sidebar Search Example
=======================

Sidebar search form (AdminLTE `sidebar-form`).

## Default Value

```
<?php use cinghie\adminlte\widgets\SidebarSearch; ?>

<?= SidebarSearch::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\SidebarSearch; ?>

<?= SidebarSearch::widget([
    'placeholder' => 'Search…',
]) ?>
```

| Property | Default |
|----------|---------|
| `placeholder` | `Search` |

The form uses `method="get"` and `action="#"`. Override the widget or wrap it if you need a real search URL.
