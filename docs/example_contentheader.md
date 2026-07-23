Content Header
===============

Page title, optional subtitle and breadcrumbs (AdminLTE content-header).

## Default Value

```
<?php use cinghie\adminlte\widgets\ContentHeader; ?>

<?= ContentHeader::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\ContentHeader; ?>

<?= ContentHeader::widget([
    'title' => $this->title,
    'subtitle' => '<small>Overview</small>',   // HTML allowed
    'breadcrumbs' => $this->params['breadcrumbs'] ?? [],
]) ?>
```

| Property | Default |
|----------|---------|
| `title` | `Dashboard` |
| `subtitle` | `<small>Version 2.0</small>` |
| `breadcrumbs` | rendered via `yii\widgets\Breadcrumbs` when non-empty |

Place inside `.content-wrapper` before `.content`.
