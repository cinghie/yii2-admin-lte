Content Header
===============

## Default Value

```
<?php use cinghie\adminlte\widgets\ContentHeader; ?>

<!-- content header -->
<?= ContentHeader::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\ContentHeader; ?>

<!-- content header -->
<?= ContentHeader::widget([
    'title' => $this->title,
    'subtitle' => '',
    'breadcrumbs' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
]) ?>
```
